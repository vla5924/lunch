<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileInfoController extends Controller
{
    public function index()
    {
        $this->requirePermission('view profiles');

        return view('pages.settings.information');
    }

    public function store(Request $request)
    {
        $this->requirePermission('view profiles');
        $request->validate([
            'display_name' => 'nullable',
            'notes' => 'nullable',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $user->display_name = $request->get('display_name');
        $user->notes = $request->get('notes');
        $user->save();

        return redirect()->back()->withSuccess(__('settings.information_updated_successfully'));
    }
}
