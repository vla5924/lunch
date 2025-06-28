<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\User;
use App\Models\UserNotificationSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{

    public function edit()
    {
        $locales = LanguageHelper::localeNames();
        $notification = UserNotificationSettings::find(Auth::user()->id);

        return view('pages.users.settings', [
            'locales' => $locales,
            'notif' => $notification,
        ]);
    }

    public function updateApp(Request $request)
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

    public function updateNotification(Request $request)
    {
        $request->validate([
            'profile_comment' => 'sometimes|accepted',
            'comment_reply' => 'sometimes|accepted',
            'planned_visit' => 'sometimes|accepted',
        ]);

        $settings = UserNotificationSettings::find(Auth::user()->id);
        $settings->profile_comment = ($request->profile_comment === "on");
        $settings->comment_reply = ($request->comment_reply === "on");
        $settings->planned_visit = ($request->planned_visit === "on");
        $settings->save();

        return redirect()->back()->withSuccess(__('users.settings_saved'));
    }

    public function removeYandexId()
    {
        $user = Auth::user();
        $user->yandex_id = null;
        $user->save();

        return redirect()->back()->withSuccess(__('users.yandex_unlinked'));
    }
}
