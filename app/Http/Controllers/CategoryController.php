<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    const PER_PAGE = 30;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view categories');

        $categories = Category::orderBy('name')->paginate(self::PER_PAGE);

        return view('pages.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('create categories');

        $criterias = Criteria::orderBy('name')->get();

        return view('pages.categories.create', [
            'criterias' => $criterias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create categories');
        $request->validate([
            'name' => 'required',
            'criteria_ids' => 'required|array',
            'criteria_ids.*' => 'exists:criterias,id',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $this->setUserId($category);
        $category->save();
        $category->criterias()->attach($request->criteria_ids);

        return redirect()->route('categories.show', $category->id)->with('success', __('categories.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $this->requirePermission('view categories');

        return view('pages.categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->requirePermission('edit categories');

        $criterias = Criteria::orderBy('name')->get();

        return view('pages.categories.edit', [
            'category' => $category,
            'criterias' => $criterias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->requirePermission('edit categories');
        $request->validate([
            'name' => 'required',
            'criteria_ids' => 'required|array',
            'criteria_ids.*' => 'exists:criterias,id',
        ]);

        $category->name = $request->name;
        $category->save();
        $category->criterias()->sync($request->criteria_ids);

        return redirect()->route('categories.show', $category->id)->with('success', __('categories.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->requirePermission('delete categories');

        $category->delete();

        return redirect()->route('categories.index')->with('success', __('categories.deleted_successfully'));
    }
}
