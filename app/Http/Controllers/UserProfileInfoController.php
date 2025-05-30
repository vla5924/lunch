<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileInfoController extends Controller
{
    public function index()
    {
        return view('pages.settings.information');
    }

    public function store(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->notes = $request->has('notes') ? $request->notes : null;
        $user->save();

        return redirect()->back()->withSuccess(__('settings.information_updated_successfully'));
    }
}
