<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class TelegramAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('telegram')->redirect();
    }

    public function callback()
    {
        $telegramUser = Socialite::driver('telegram')->user();
        $user = User::updateOrCreate(
            [
                'tg_id' => $telegramUser->getId(),
            ],
            [
                'tg_name' => $telegramUser->getName(),
                'tg_username' => $telegramUser->getNickname(),
                'avatar' => $telegramUser->getAvatar(),
            ]
        );

        Auth::login($user);

        return redirect('/');
    }
}
