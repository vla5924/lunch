<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    const SUPPORTED_LOCALES = [
        'ru' => 'Русский',
        'en' => 'English',
    ];

    const DEFAULT_LOCALE = 'ru';

    public function edit()
    {
        return view('pages.users.settings', [
            'locales' => self::SUPPORTED_LOCALES,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        if (\in_array($request->locale, array_keys(self::SUPPORTED_LOCALES)))
            $user->locale = $request->locale;
        else
            $user->locale = self::DEFAULT_LOCALE;
        $user->save();

        return redirect()->back()->withSuccess(__('settings.settings_saved', [], $user->locale));
    }

    public function removeYandexId()
    {
        $user = Auth::user();
        $user->yandex_id = null;
        $user->save();

        return redirect()->back()->withSuccess('Привязка аккаунта Яндекса отменена');
    }
}
