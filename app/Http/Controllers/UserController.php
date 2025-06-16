<?php

namespace App\Http\Controllers;

use App\Helpers\CommentHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const PER_PAGE = 30;

    private function requireEditPermission(int $id)
    {
        $u = Auth::user();
        if ($u->id != $id && !$u->hasPermissionTo('edit users'))
            abort(403);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view users');

        $users = User::orderBy('id')->paginate(self::PER_PAGE);

        return view('pages.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.users.show', [
            'user' => $user,
            'comments' => $user->comments()->paginate(CommentHelper::PER_PAGE),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->requireEditPermission($user->id);

        return view('pages.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->requireEditPermission($user->id);
        $request->validate([
            'display_name' => 'nullable',
            'notes' => 'nullable',
        ]);

        $user->display_name = $request->get('display_name');
        $user->notes = $request->get('notes');
        $user->save();

        return redirect()->back()->withSuccess(__('users.information_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort(404);
    }
}
