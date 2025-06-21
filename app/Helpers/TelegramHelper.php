<?php

namespace App\Helpers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TelegramHelper
{
    const SHOW_ROUTES = [
        User::class => 'users.show',
        Restaurant::class => 'restaurants.show',
    ];

    public static function link(string $text, string $url): string
    {
        return "[$text]($url)";
    }

    public static function modelLink(Model $model): string
    {
        return self::link($model->name, route(self::SHOW_ROUTES[get_class($model)], $model->id));
    }
}
