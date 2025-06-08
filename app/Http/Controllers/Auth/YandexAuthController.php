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
                return redirect()->route('users.settings')->with('failure', 'Аккаунт Яндекса привязан к другому пользователю');
            }
            $currentUser->yandex_id = $yandexUser->getId();
            $currentUser->save();
            return redirect()->route('users.settings')->with('success', 'Аккаунт Яндекса привязан успешно');
        }
        if ($user == null) {
            return redirect()->route('login')->with('failure', 'Сначала нужно авторизоваться через Telegram и привязать аккаунт Яндекса в настройках');
        }
        Auth::login($user);
        return redirect('/');
    }
}
