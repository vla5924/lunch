<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Restaurant;
use App\Models\Visit;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('create visits');

        return view('pages.visits.create');
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
            'group_id' => 'required|integer',
            'restaurant_id' => 'required|integer',
        ]);
        $this->requireExistingId(Group::class, $request->group_id);
        $this->requireExistingId(Restaurant::class, $request->restaurant_id);

        $visit = new Visit;
        $visit->notes = $request->notes;
        $visit->datetime = $request->datetime;
        $visit->group_id = $request->group_id;
        $visit->restaurant_id = $request->restaurant_id;
        $this->setUserId($visit);
        $visit->save();

        return redirect()->route('visits.show', $visit->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit)
    {
        $this->requirePermission('view visits');

        return view('pages.visits.show', [
            'visit' => $visit,
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
            'group_id' => 'required|integer',
            'restaurant_id' => 'required|integer',
        ]);
        $this->requireExistingId(Group::class, $request->group_id);
        $this->requireExistingId(Restaurant::class, $request->restaurant_id);

        $visit->notes = $request->notes;
        $visit->datetime = $request->datetime;
        $visit->group_id = $request->group_id;
        $visit->restaurant_id = $request->restaurant_id;
        $visit->save();

        return redirect()->route('visits.show', $visit->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        $this->requirePermission('delete visits');

        $visit->delete();

        return redirect()->route('visits.index')->with('success', __('categories.category_deleted_successfully'));
    }
}
