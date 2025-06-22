<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Event;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class RouteHelper
{
    const SHOW = [
        Category::class => 'categories.show',
        Criteria::class => 'criterias.show',
        Evaluation::class => 'evaluations.show',
        Event::class => 'events.show',
        Restaurant::class => 'restaurants.show',
        User::class => 'users.show',
        Visit::class => 'visits.show',
    ];

    public static function showName(Model $model): string
    {
        return self::SHOW[get_class($model)];
    }

    public static function show(Model|string $model, ?int $id = null, bool $absolute = true)
    {
        $view = $model;
        if ($model instanceof Model) {
            $view = self::SHOW[get_class($model)];
            $id = $model->id;
        }
        return route($view, $id, absolute: $absolute);
    }
}
