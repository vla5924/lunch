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
        $user = User::create([
            'id' => 1,
            'tg_id' => env('ADMIN_TG_ID'),
            'tg_name' => env('ADMIN_TG_NAME', 'admin'),
            'tg_username' => env('ADMIN_TG_USERNAME', 'admin'),
            'yandex_id' => env('ADMIN_YANDEX_ID'),
        ]);
        $user->assignRole('admin');
    }
}
