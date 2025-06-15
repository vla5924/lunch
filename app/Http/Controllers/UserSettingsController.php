<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{

    public function edit()
    {
        return view('pages.users.settings', [
            'locales' => LanguageHelper::localeNames(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        if (\in_array($request->locale, LanguageHelper::SUPPORTED_LOCALES))
            $user->locale = $request->locale;
        else
            $user->locale = LanguageHelper::DEFAULT_LOCALE;
        $user->save();

        return redirect()->back()->withSuccess(__('users.settings_saved', locale: $user->locale));
    }

    public function removeYandexId()
    {
        $user = Auth::user();
        $user->yandex_id = null;
        $user->save();

        return redirect()->back()->withSuccess(__('users.yandex_unlinked'));
    }
}
