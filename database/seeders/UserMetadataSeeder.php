<?php

namespace Database\Seeders;

use App\Events\UserCreated;
use App\Listeners\CreateUserMetadata;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMetadataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(['id']);
        foreach ($users as $user) {
            $event = new UserCreated($user);
            $listener = new CreateUserMetadata;
            $listener->handle($event);
        }
    }
}
