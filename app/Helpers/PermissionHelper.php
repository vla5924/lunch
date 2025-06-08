<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function canActOwned(string $permissionAll, string $permissionOwned, int $ownerId)
    {
        $user = Auth::user();
        if (!$user)
            return false;
        if ($user->can($permissionAll))
            return true;
        if ($user->can($permissionOwned) && $user->id == $ownerId)
            return true;
        return false;
    }
}
