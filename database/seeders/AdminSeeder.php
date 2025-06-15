<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate([
            'id' => config('lunch.admin_id'),
            'tg_id' => config('lunch.admin_tg_id'),
        ], [
            'tg_name' => config('lunch.admin_tg_name'),
            'tg_username' => config('lunch.admin_tg_username'),
            'yandex_id' => config('lunch.admin_yandex_id'),
        ]);
        $user->assignRole('admin');
    }
}
