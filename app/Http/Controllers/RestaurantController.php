<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view restaurants');

        $restaurants = Restaurant::orderBy('name')->paginate(self::PER_PAGE);

        return view('pages.restaurants.index', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('create restaurants');

        $categories = Category::orderBy('name')->get();

        return view('pages.restaurants.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create restaurants');
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'yandex_map_widget' => 'nullable',
            'category_id' => 'required|integer',
        ]);

        $restaurant = new Restaurant;
        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->yandex_map_widget = $request->yandex_map_widget;
        $restaurant->category_id = $request->category_id;
        $restaurant->user_id = Auth::user()->id;
        $restaurant->save();

        return redirect()->route('restaurants.show', $restaurant->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $this->requirePermission('view restaurants');

        return view('pages.restaurants.show', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->requirePermission('edit restaurants');

        $categories = Category::orderBy('name');

        return view('pages.restaurants.edit', [
            'restaurant' => $restaurant,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $this->requirePermission('edit restaurants');
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'yandex_map_widget' => 'nullable',
            'yandex_reviews_widget' => 'nullable',
            'category_id' => 'required|integer',
        ]);

        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->yandex_map_widget = $request->yandex_map_widget;
        $restaurant->yandex_reviews_widget = $request->yandex_reviews_widget;
        $restaurant->category_id = $request->category_id;
        $restaurant->save();

        return redirect()->route('restaurants.show', $restaurant->id)->with('success', __('categories.category_created_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->requirePermission('delete restaurants');

        $restaurant->delete();

        return redirect()->route('restaurants.index')->with('success', __('categories.category_deleted_successfully'));
    }
}
