<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $restaurantId)
    {
        $this->requirePermission('view evaluations');

        $restaurantId = (int)$restaurantId;
        $evaluations = Evaluation::where('restaurant_id', $restaurantId)->get();

        return view('pages.evaluations.index', [
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $restaurantId)
    {
        $this->requirePermission('create evaluations');

        $restaurantId = (int)$restaurantId;
        $restaurant = Restaurant::where('id', $restaurantId)->first();
        if (!$restaurant) {
            abort(404);
        }
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->where('restaurant_id', $restaurantId)->first();
        if ($evaluation) {
            return redirect()->route('evaluations.show', $evaluation->id)->with('failure', __('Alr exist!'));
        }

        return view('pages.evaluations.create', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create evaluations');
        $request->validate([
            'notes' => 'nullable',
            'restaurant_id' => 'required|integer',
            'criterias' => 'list',
            'values' => 'list',
        ]);

        $restaurantId = (int)$request->restaurant_id;
        $restaurant = Restaurant::where('id', $restaurantId)->first();
        if (!$restaurant) {
            abort(404);
        }
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->where('restaurant_id', $restaurantId)->first();
        if ($evaluation) {
            abort(403);
        }
        // check all criteria IDs and validate values...
        $evaluation = new Evaluation;
        $evaluation->notes = $request->notes;
        $evaluation->restaurant_id = $restaurantId;
        $evaluation->user_id = Auth::user()->id;
        $evaluation->save();
        // create all CriteriaEvaluation

        return redirect()->route('evaluations.show', $evaluation->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $this->requirePermission('view evaluations');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $this->requireCurrentUser($evaluation->user_id);
        $this->requirePermission('edit evaluations');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $this->requireCurrentUser($evaluation->user_id);
        $this->requirePermission('edit evaluations');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        $this->requireCurrentUser($evaluation->user_id);
        $this->requirePermission('delete criterias');

        $restaurantId = $evaluation->restaurant->id;
        foreach ($evaluation->criterias as $criteria) {
            $criteria->delete();
        }
        $evaluation->delete();

        return redirect()->route('restaurants.show', $restaurantId)->with('success', __('categories.category_deleted_successfully'));
    }
}
