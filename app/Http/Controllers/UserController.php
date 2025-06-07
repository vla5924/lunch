<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    const SUPPORTED_LOCALES = [
        'ru' => 'Русский',
        'en' => 'English',
    ];

    const DEFAULT_LOCALE = 'ru';

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
            'locales' => self::SUPPORTED_LOCALES,
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

        return redirect()->back()->withSuccess(__('settings.information_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort(404);
    }

    public function editSettings()
    {
        return redirect()->route('users.edit', Auth::user()->id);
    }

    public function updateSettings(Request $request)
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

    public function editGroups(int $id)
    {
        $this->requirePermission('assign groups');

        $user = $this->requireExistingId(User::class, $id);
        $groups = Group::get();

        return view('pages.users.groups', [
            'user' => $user,
            'groups' => $groups,
        ]);
    }

    public function updateGroups(Request $request, int $id)
    {
        $this->requirePermission('assign groups');
        $request->validate([
            'group_ids' => 'array',
            'group_ids.*' => 'exists:groups,id',
        ]);
        $user = $this->requireExistingId(User::class, $id);

        $user->groups()->sync($request->group_ids);

        return redirect()->back()->withSuccess('Назначение групп успешно обновлено');
    }

    public function editPermissions(int $id)
    {
        $this->requirePermission('assign permissions');

        $user = $this->requireExistingId(User::class, $id);
        $permissions = Permission::get();

        return view('pages.users.permissions', [
            'user' => $user,
            'permissions' => $permissions,
        ]);
    }

    public function updatePermissions(Request $request, int $id)
    {
        $this->requirePermission('assign groups');
        $request->validate([
            'permission_ids' => 'array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);
        $user = $this->requireExistingId(User::class, $id);

        $user->permissions()->sync($request->permission_ids);

        return redirect()->back()->withSuccess('Права пользователя успешно обновлены');
    }

    public function editRoles(int $id)
    {
        $this->requirePermission('assign roles');

        $user = $this->requireExistingId(User::class, $id);
        $roles = Role::get();

        return view('pages.users.roles', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function updateRoles(Request $request, int $id)
    {
        $this->requirePermission('assign roles');
        $request->validate([
            'role_id' => 'exists:roles,id',
        ]);
        $user = $this->requireExistingId(User::class, $id);

        $user->roles()->sync([$request->role_id]);

        return redirect()->back()->withSuccess('Роли пользователя успешно обновлены');
    }
}
