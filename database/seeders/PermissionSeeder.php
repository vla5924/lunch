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

        Permission::create(['name' => 'view profiles']);

        Permission::create(['name' => 'view restaurants']);
        Permission::create(['name' => 'create restaurants']);
        Permission::create(['name' => 'edit restaurants']);
        Permission::create(['name' => 'delete restaurants']);

        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'view visits']);
        Permission::create(['name' => 'create visits']);
        Permission::create(['name' => 'edit visits']);
        Permission::create(['name' => 'delete visits']);

        Permission::create(['name' => 'view criterias']);
        Permission::create(['name' => 'create criterias']);
        Permission::create(['name' => 'edit criterias']);
        Permission::create(['name' => 'delete criterias']);

        Permission::create(['name' => 'view groups']);
        Permission::create(['name' => 'create groups']);
        Permission::create(['name' => 'edit groups']);
        Permission::create(['name' => 'delete groups']);
        Permission::create(['name' => 'assign groups']);

        Permission::create(['name' => 'view evaluations']);
        Permission::create(['name' => 'create evaluations']);
        Permission::create(['name' => 'edit evaluations']);
        Permission::create(['name' => 'delete evaluations']);

        Permission::create(['name' => 'view comments']);
        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'edit comments']);
        Permission::create(['name' => 'edit all comments']);
        Permission::create(['name' => 'delete comments']);
        Permission::create(['name' => 'delete all comments']);

        Permission::create(['name' => 'view reactions']);
        Permission::create(['name' => 'create reactions']);
        Permission::create(['name' => 'edit reactions']);
        Permission::create(['name' => 'delete reactions']);

        Permission::create(['name' => 'create comment reactions']);
        Permission::create(['name' => 'delete comment reactions']);

        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'assign permissions']);

        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'assign roles']);

        Role::create(['name' => 'noname']);

        Role::create(['name' => 'user'])->givePermissionTo([
            'view profiles',
            'view restaurants',
            'view categories',
            'view visits',
            'view criterias',
            'view groups',
            'view evaluations',
            'create evaluations',
            'edit evaluations',
            'delete evaluations',
            'view comments',
            'create comments',
            'edit comments',
            'delete comments',
            'view reactions',
            'create comment reactions',
            'delete comment reactions',
        ]);

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}
