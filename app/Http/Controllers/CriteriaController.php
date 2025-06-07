<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view criterias');

        $criterias = Criteria::orderBy('name')->get();

        return view('pages.criterias.index', [
            'criterias' => $criterias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('create criterias');

        return view('pages.criterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create criterias');
        $request->validate([
            'name_en' => 'required',
            'name_ru' => 'required',
            'description_en' => 'required',
            'description_ru' => 'required',
            'fa_icon' => 'nullable',
            'min_value' => 'required',
            'max_value' => 'required',
            'step' => 'required',
            'impact' => 'required',
        ]);

        $criteria = new Criteria;
        $criteria->name_en = $request->name_en;
        $criteria->name_ru = $request->name_ru;
        $criteria->description_en = $request->description_en;
        $criteria->description_ru = $request->description_ru;
        $criteria->fa_icon = $request->fa_icon;
        $criteria->min_value = $request->min_value;
        $criteria->max_value = $request->max_value;
        $criteria->step = $request->step;
        $criteria->impact = $request->impact;
        $criteria->user_id = Auth::user()->id;
        $criteria->save();

        return redirect()->route('criterias.show', $criteria->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criteria)
    {
        $this->requirePermission('view criterias');

        return view('pages.criterias.show', [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria)
    {
        $this->requirePermission('edit criterias');

        return view('pages.criterias.edit', [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criteria)
    {
        $this->requirePermission('edit criterias');
        $request->validate([
            'name_en' => 'required',
            'name_ru' => 'required',
            'description_en' => 'required',
            'description_ru' => 'required',
            'fa_icon' => 'nullable',
            'min_value' => 'required',
            'max_value' => 'required',
            'step' => 'required',
            'impact' => 'required',
        ]);

        $criteria->name_en = $request->name_en;
        $criteria->name_ru = $request->name_ru;
        $criteria->description_en = $request->name_ru;
        $criteria->description_ru = $request->name_ru;
        $criteria->fa_icon = $request->fa_icon;
        $criteria->min_value = $request->min_value;
        $criteria->max_value = $request->max_value;
        $criteria->step = $request->step;
        $criteria->impact = $request->impact;
        $criteria->save();

        return redirect()->route('criterias.show', $criteria->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        $this->requirePermission('delete criterias');

        $criteria->delete();

        return redirect()->route('criterias.index')->with('success', __('categories.category_deleted_successfully'));
    }
}
