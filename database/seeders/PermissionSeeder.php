<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::findOrCreate('view users');
        Permission::findOrCreate('edit users');
        Permission::findOrCreate('assign permissions');
        Permission::findOrCreate('assign roles');

        Permission::findOrCreate('view restaurants');
        Permission::findOrCreate('create restaurants');
        Permission::findOrCreate('edit restaurants');
        Permission::findOrCreate('delete restaurants');
        Permission::findOrCreate('ban restaurants');

        Permission::findOrCreate('view categories');
        Permission::findOrCreate('create categories');
        Permission::findOrCreate('edit categories');
        Permission::findOrCreate('delete categories');

        Permission::findOrCreate('view visits');
        Permission::findOrCreate('create visits');
        Permission::findOrCreate('edit visits');
        Permission::findOrCreate('delete visits');

        Permission::findOrCreate('view criterias');
        Permission::findOrCreate('create criterias');
        Permission::findOrCreate('edit criterias');
        Permission::findOrCreate('delete criterias');

        Permission::findOrCreate('view evaluations');
        Permission::findOrCreate('create evaluations');
        Permission::findOrCreate('edit owned evaluations');
        Permission::findOrCreate('edit all evaluations');
        Permission::findOrCreate('delete owned evaluations');
        Permission::findOrCreate('delete all evaluations');

        Permission::findOrCreate('view comments');
        Permission::findOrCreate('create comments');
        Permission::findOrCreate('edit owned comments');
        Permission::findOrCreate('edit all comments');
        Permission::findOrCreate('delete owned comments');
        Permission::findOrCreate('delete all comments');

        Permission::findOrCreate('view reactions');
        Permission::findOrCreate('create reactions');
        Permission::findOrCreate('edit reactions');
        Permission::findOrCreate('delete reactions');

        Permission::findOrCreate('add comment reactions');
        Permission::findOrCreate('remove comment reactions');

        Permission::findOrCreate('view events');
        Permission::findOrCreate('create events');
        Permission::findOrCreate('edit events');
        Permission::findOrCreate('delete events');

        Role::findOrCreate('noname');

        Role::findOrCreate('user')->givePermissionTo([
            'view users',
            'view restaurants',
            'ban restaurants',
            'view categories',
            'view visits',
            'view criterias',
            'view evaluations',
            'create evaluations',
            'edit owned evaluations',
            'delete owned evaluations',
            'view comments',
            'create comments',
            'edit owned comments',
            'delete owned comments',
            'view reactions',
            'add comment reactions',
            'remove comment reactions',
            'view events',
        ]);

        Role::findOrCreate('admin')->givePermissionTo(Permission::all());
    }
}
