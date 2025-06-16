<?php

namespace App\Http\Controllers;

use App\Helpers\DeleteHelper;
use App\Helpers\EvaluationHelper;
use App\Models\Criteria;
use App\Models\CriteriaEvaluation;
use App\Models\Evaluation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{

    public function restaurant(int $restaurantId)
    {
        $this->requirePermission('view evaluations');

        $restaurant = $this->requireExistingId(Restaurant::class, $restaurantId);
        $evaluations = Evaluation::where('restaurant_id', $restaurant->id)->get();

        return view('pages.evaluations.restaurant', [
            'evaluations' => $evaluations,
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $restaurantId)
    {
        $this->requirePermission('create evaluations');

        $restaurant = $this->requireExistingId(Restaurant::class, $restaurantId);
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->where('restaurant_id', $restaurant->id)->first();
        if ($evaluation) {
            return redirect()->route('evaluations.show', $evaluation->id)->with('failure', __('evaluations.you_already_evaluated'));
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
            'restaurant_id' => 'exists:restaurants,id',
            'criteria_ids' => 'array',
            'criteria_ids.*' => 'exists:criterias,id',
            'criteria_values' => 'array',
        ]);

        $restaurant = $this->requireExistingId(Restaurant::class, $request->restaurant_id);
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->where('restaurant_id', $restaurant->id)->first();
        if ($evaluation) {
            abort(403);
        }
        $numIds = count($request->criteria_ids);
        if ($numIds != count($request->criteria_values) || $request->criteria_ids != array_unique($request->criteria_ids)) {
            return redirect()->back()->with('failure', __('evaluations.invalid_request_parameters'));
        }
        $criterias = [];
        $weights = [];
        for ($i = 0; $i < $numIds; $i++) {
            $criteria = Criteria::where('id', $request->criteria_ids[$i])->first();
            if (!$criteria)
                return redirect()->back()->with('failure', __('evaluations.invalid_request_parameters'));
            $value = $request->criteria_values[$i];
            if (!\in_array($value, $criteria->values))
                return redirect()->back()->with('failure', __('evaluations.illegal_criteria_value', ['name' => $criteria->name]));
            $criterias[$criteria->id] = $value;
            $weights[$criteria->id] = $criteria->impact;
        }
        $evaluation = new Evaluation;
        $evaluation->notes = $request->notes;
        $evaluation->total = EvaluationHelper::totalFromArrays($criterias, $weights);
        $evaluation->restaurant_id = $restaurant->id;
        $this->setUserId($evaluation);
        $evaluation->save();
        foreach ($criterias as $id => $value) {
            $ce = new CriteriaEvaluation;
            $ce->value = $value;
            $ce->criteria_id = $id;
            $ce->evaluation_id = $evaluation->id;
            $ce->save();
        }

        return redirect()->route('evaluations.show', $evaluation->id)->withSuccess(__('evaluations.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $this->requirePermission('view evaluations');

        return view('pages.evaluations.show', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $this->requireCurrentUser($evaluation->user_id);
        $this->requirePermission('edit owned evaluations');

        return view('pages.evaluations.edit', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $this->requireCurrentUser($evaluation->user_id);
        $this->requirePermission('edit owned evaluations');
        $request->validate([
            'notes' => 'nullable',
            'criteria_ids' => 'array',
            'criteria_ids.*' => 'exists:criterias,id',
            'criteria_values' => 'array',
        ]);

        $numIds = count($request->criteria_ids);
        if (
            $numIds != count($request->criteria_values)
            || $numIds != $evaluation->criterias->count()
            || $request->criteria_ids != array_unique($request->criteria_ids)
        ) {
            return redirect()->back()->with('failure', __('evaluations.invalid_request_parameters'));
        }
        $criterias = [];
        $weights = [];
        for ($i = 0; $i < $numIds; $i++) {
            $criteria = Criteria::where('id', $request->criteria_ids[$i])->first();
            if (!$criteria)
                return redirect()->back()->with('failure', 'Неверные параметры запроса');
            $value = $request->criteria_values[$i];
            if (!\in_array($value, $criteria->values))
                return redirect()->back()->with('failure', __('evaluations.illegal_criteria_value', ['name' => $criteria->name]));
            $criterias[$criteria->id] = $value;
            $weights[$criteria->id] = $criteria->impact;
        }
        $evaluation->notes = $request->notes;
        $evaluation->total = EvaluationHelper::totalFromArrays($criterias, $weights);
        $evaluation->save();
        foreach ($evaluation->criterias as $ce) {
            $ce->value = $criterias[$ce->criteria->id];
            $ce->save();
        }

        return redirect()->route('evaluations.show', $evaluation->id)->withSuccess(__('evaluations.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        $this->requireCurrentUser($evaluation->user_id);
        $this->requirePermission('delete owned evaluations');

        $restaurantId = $evaluation->restaurant->id;
        DeleteHelper::deleteEvaluation($evaluation);

        return redirect()->route('restaurants.show', $restaurantId)->with('success', __('evaluations.deleted_successfully'));
    }
}
