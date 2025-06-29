<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAdminController extends Controller
{
    public function permissions(int $id)
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
        $this->requirePermission('assign permissions');
        $request->validate([
            'permission_ids' => 'array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);
        $user = $this->requireExistingId(User::class, $id);

        $user->permissions()->sync($request->permission_ids);

        return redirect()->back()->withSuccess(__('users.permissions_updated_successfully'));
    }

    public function roles(int $id)
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
            'role_ids' => 'array',
            'role_ids.*' => 'exists:roles,id',
        ]);
        $user = $this->requireExistingId(User::class, $id);

        $user->roles()->sync($request->role_ids);

        return redirect()->back()->withSuccess(__('users.roles_updated_successfully'));
    }
}
