<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
                'name' => $telegramUser->getName(),
                'tg_username' => $telegramUser->getNickname(),
                'avatar' => $telegramUser->getAvatar(),
            ]
        );
        if ($telegramUser->getNickname() == 'vla5924') {
            $user->assignRole('admin');
        }

        Auth::login($user);

        return redirect('/');
    }
}
