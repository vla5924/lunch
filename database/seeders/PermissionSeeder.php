<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        Permission::create(['name' => 'view comments']);
        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'edit comments']);
        Permission::create(['name' => 'edit all comments']);
        Permission::create(['name' => 'delete comments']);
        Permission::create(['name' => 'delete all comments']);

        Role::create(['name' => 'noname']);

        Role::create(['name' => 'user'])->givePermissionTo([
            'view profiles',
            'view restaurants',
            'view comments',
            'create comments',
            'edit comments',
            'delete comments',
        ]);

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
    }
}
