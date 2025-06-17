<?php

namespace App\Http\Controllers;

use App\Models\BannedRestaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannedRestaurantController extends Controller
{
    public function ban(Request $request)
    {
        $this->requirePermission('ban restaurants');
        $request->validate([
            'restaurant_id' => 'exists:restaurants,id',
        ]);

        $user = Auth::user();
        if (BannedRestaurant::where('user_id', $user->id)->where('restaurant_id', $request->restaurant_id)->first()) {
            return redirect()->back()->with('failure', __('restaurants.already_banned'));
        }
        $limit = config('lunch.restaurant_ban_limit');
        $count = BannedRestaurant::where('user_id', $user->id)->count();
        if ($count >= $limit) {
            return redirect()->back()->with('failure', __('restaurants.ban_limit_reached'));
        }
        $ban = new BannedRestaurant;
        $ban->restaurant_id = $request->restaurant_id;
        $ban->user_id = $user->id;
        $ban->save();

        return redirect()->back()->with('success', __('restaurants.banned_successfully'));
    }

    public function unban(Request $request)
    {
        $this->requirePermission('ban restaurants');
        $request->validate([
            'restaurant_id' => 'exists:restaurants,id',
        ]);

        $user = Auth::user();
        $ban = BannedRestaurant::where('user_id', $user->id)->where('restaurant_id', $request->restaurant_id)->first();
        if (!$ban) {
            return redirect()->back()->with('failure', __('restaurants.was_not_banned'));
        }
        $ban->delete();

        return redirect()->back()->with('success', __('restaurants.unbanned_successfully'));
    }
}
