<?php

namespace App\Helpers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TelegramHelper
{
    public static function link(string $text, string $url): string
    {
        return "[$text]($url)";
    }

    public static function modelLink(Model $model): string
    {
        return self::link($model->name, RouteHelper::show($model));
    }
}
