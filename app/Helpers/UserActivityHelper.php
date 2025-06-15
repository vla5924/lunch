<?php

namespace App\Helpers;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class UserActivityHelper
{
    public static function getOnline(int|null $id = null)
    {
        $id ??= Auth::user()->id;
        return UserActivity::firstOrCreate(['user_id' => $id], ['online_at' => null])->online_at;
    }

    public static function setOnline($timestamp = null, int|null $id = null): void
    {
        $id ??= Auth::user()->id;
        UserActivity::updateOrCreate(['user_id' => $id], ['online_at' => $timestamp ?? now()]);
    }
}
