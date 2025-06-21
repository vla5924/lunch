<?php

namespace App\Helpers;

use App\Models\RestaurantScore;

class RestaurantScoreHelper
{
    public static function getRatingQuery(int $categoryId)
    {
        return RestaurantScore::query()
            ->join('restaurants', 'restaurant_id', '=', 'restaurants.id')
            ->where('restaurants.category_id', $categoryId)
            ->orderBy('bans')
            ->orderByDesc('score')
            ->orderBy('restaurants.name');
    }

    public static function setOutdated(int $restaurantId, bool $outdated = true): void
    {
        RestaurantScore::updateOrInsert(['restaurant_id' => $restaurantId], ['outdated' => $outdated]);
    }
}
