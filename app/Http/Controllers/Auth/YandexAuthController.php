<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class YandexAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function callback()
    {
        $yandexUser = Socialite::driver('yandex')->user();
        $currentUser = Auth::user();
        $user = User::where('yandex_id', $yandexUser->getId())->first();
        if ($currentUser != null) {
            if ($user != null && $user->id != $currentUser->id) {
                return redirect()->route('users.settings')->with('failure', __('auth.yandex_linked_to_another_user'));
            }
            $currentUser->yandex_id = $yandexUser->getId();
            $currentUser->save();
            return redirect()->route('users.settings')->with('success', __('auth.yandex_linked_successfully'));
        }
        if ($user == null) {
            return redirect()->route('login')->with('failure', __('auth.yandex_telegram_first'));
        }
        Auth::login($user);
        return redirect()->intended('/');
    }
}
