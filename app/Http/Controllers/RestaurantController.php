<?php

namespace App\Http\Controllers;

use App\Helpers\CommentHelper;
use App\Helpers\DeleteHelper;
use App\Helpers\EvaluationHelper;
use App\Models\BannedRestaurant;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CriteriaEvaluation;
use App\Models\Evaluation;
use App\Models\Restaurant;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    const PER_PAGE = 20;

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
            'location' => 'required',
            'yandex_map_widget' => 'nullable',
            'category_id' => 'exists:categories,id',
        ]);

        $restaurant = new Restaurant;
        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->location = $request->location;
        $restaurant->yandex_map_widget = $request->yandex_map_widget;
        $restaurant->category_id = $request->category_id;
        $this->setUserId($restaurant);
        $restaurant->save();

        return redirect()->route('restaurants.show', $restaurant->id)->with('success', __('restaurants.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $this->requirePermission('view restaurants');

        $restaurantComments = Comment::query()
            ->where('commentable_type', Restaurant::class)
            ->where('commentable_id', $restaurant->id);
        $visitComments = Comment::query()
            ->where('commentable_type', Visit::class)
            ->join('visits', 'comments.commentable_id', '=', 'visits.id')
            ->where('visits.restaurant_id', $restaurant->id)
            ->select('comments.*');
        $comments = $restaurantComments->unionAll($visitComments)
            ->orderBy('created_at', 'asc')
            ->paginate(CommentHelper::PER_PAGE);
        $evaluation = Evaluation::where('user_id', Auth::user()->id)->where('restaurant_id', $restaurant->id)->first();
        $userValues = [];
        if ($evaluation) {
            foreach ($evaluation->criterias as $ce) {
                $userValues[$ce->criteria->id] = ['value' => $ce->value, 'percentage' => $ce->percentage];
            }
        }
        $requiredCriterias = $restaurant->category->criterias;
        $avgValues = [];
        $displayValues = [];
        foreach ($requiredCriterias as $criteria) {
            $id = $criteria->id;
            if (array_key_exists($id, $userValues))
                $displayValues[$id] = $userValues[$id];
            else
                $displayValues[$id] = ['value' => 0, 'percentage' => 0];
            $ces = CriteriaEvaluation::query()
                ->join('evaluations', 'criteria_evaluations.evaluation_id', '=', 'evaluations.id')
                ->where('evaluations.restaurant_id', $restaurant->id)
                ->where('criteria_id', $id)
                ->select('criteria_evaluations.*')
                ->get();
            if ($ces->isNotEmpty())
                $avgValues[$id] = ['value' => $ces->avg('value'), 'percentage' => $ces->avg('percentage')];
            else
                $avgValues[$id] = ['value' => 0, 'percentage' => 0];
        }
        $chart = [];
        foreach ($requiredCriterias as $criteria) {
            $chart[$criteria->id] = [
                'name' => $criteria->name,
                'description' => $criteria->description,
                'range_tooltip' => __('evaluations.range_tooltip', [
                    'min' => $criteria->min_value,
                    'max' => $criteria->max_value,
                ]),
                'avg' => $avgValues[$criteria->id],
                'user' => $displayValues[$criteria->id],
            ];
        }
        $lastVisit = Visit::where('restaurant_id', $restaurant->id)->orderBy('datetime', 'desc')->limit(1)->first();
        $banned = BannedRestaurant::where('user_id', Auth::user()->id)->where('restaurant_id', $restaurant->id)->count();


        return view('pages.restaurants.show', [
            'restaurant' => $restaurant,
            'comments' => $comments,
            'evaluation' => $evaluation,
            'evaluation_avg' => EvaluationHelper::formatTotal($restaurant->evaluations->avg('total')),
            'chart' => $chart,
            'last_visit' => $lastVisit,
            'banned' => $banned,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->requirePermission('edit restaurants');

        $categories = Category::orderBy('name')->get();

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
            'location' => 'required',
            'yandex_map_widget' => 'nullable',
            'category_id' => 'exists:categories,id',
        ]);

        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->location = $request->location;
        $restaurant->yandex_map_widget = $request->yandex_map_widget;
        $restaurant->category_id = $request->category_id;
        $restaurant->save();

        return redirect()->route('restaurants.show', $restaurant->id)->with('success', __('restaurants.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->requirePermission('delete restaurants');

        DeleteHelper::deleteRestaurant($restaurant);

        return redirect()->route('restaurants.index')->with('success', __('restaurants.deleted_successfully'));
    }
}
