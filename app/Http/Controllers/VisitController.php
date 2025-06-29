<?php

namespace App\Http\Controllers;

use App\Helpers\CommentHelper;
use App\Helpers\DeleteHelper;
use App\Models\Comment;
use App\Models\Restaurant;
use App\Models\Visit;
use App\Notifications\VisitPlanned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    const PER_PAGE = 30;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view visits');

        $visits = Visit::orderBy('datetime', 'desc')->paginate(self::PER_PAGE);

        return view('pages.visits.index', [
            'visits' => $visits,
        ]);
    }

    public function restaurant(int $restaurantId)
    {
        $this->requirePermission('view visits');

        $restaurant = $this->requireExistingId(Restaurant::class, $restaurantId);
        $visits = Visit::where('restaurant_id', $restaurant->id)->orderBy('datetime', 'desc')->paginate(self::PER_PAGE);

        return view('pages.visits.restaurant', [
            'restaurant' => $restaurant,
            'visits' => $visits,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $restaurantId)
    {
        $this->requirePermission('create visits');
        $restaurant = $this->requireExistingId(Restaurant::class, $restaurantId);

        return view('pages.visits.create', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create visits');
        $request->validate([
            'notes' => 'nullable',
            'datetime' => 'required|date',
            'restaurant_id' => 'exists:restaurants,id',
        ]);

        $visit = new Visit;
        $visit->notes = $request->notes;
        $visit->datetime = $request->datetime;
        $visit->restaurant_id = $request->restaurant_id;
        $this->setUserId($visit);
        $visit->save();

        VisitPlanned::tryNotify($visit);

        return redirect()->route('visits.show', $visit->id)->with('success', __('visits.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        $this->requirePermission('view visits');

        $comments = Comment::query()
            ->where('commentable_id', $visit->id)
            ->where('commentable_type', Visit::class)
            ->orderBy('created_by', 'asc')
            ->paginate(CommentHelper::PER_PAGE);
        $participant = $visit->participants()->where('user_id', Auth::user()->id)->count();

        return view('pages.visits.show', [
            'visit' => $visit,
            'comments' => $comments,
            'participant' => $participant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        $this->requirePermission('edit visits');

        return view('pages.visits.edit', [
            'visit' => $visit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        $this->requirePermission('edit visits');
        $request->validate([
            'notes' => 'nullable',
            'datetime' => 'required|date',
            'restaurant_id' => 'exists:restaurants,id',
        ]);

        $oldDatetime = $visit->datetime;
        $visit->notes = $request->notes;
        $visit->datetime = $request->datetime;
        $visit->restaurant_id = $request->restaurant_id;
        $visit->save();

        if ($oldDatetime != $visit->datetime) {
            VisitPlanned::tryNotify($visit);
        }

        return redirect()->route('visits.show', $visit->id)->with('success', __('visits.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        $this->requirePermission('delete visits');

        DeleteHelper::deleteVisit($visit);

        return redirect()->route('visits.index')->with('success', __('visits.deleted_successfully'));
    }

    public function participate(int $visitId)
    {
        $this->requirePermission('view visits');

        $visit = $this->requireExistingId(Visit::class, $visitId);
        $visit->participants()->attach(Auth::user()->id);

        return redirect()->route('visits.show', $visit->id)->with('success', __('visits.participation_saved'));
    }

    public function cancelParticipation(Request $request)
    {
        $this->requirePermission('view visits');
        $request->validate([
            'visit_id' => 'exists:visits,id',
        ]);

        $visit = Visit::find($request->visit_id);
        $visit->participants()->detach(Auth::user()->id);

        return redirect()->route('visits.show', $visit->id)->with('success', __('visits.participation_cancelled'));
    }
}
