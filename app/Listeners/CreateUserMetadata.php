<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\UserActivity;
use App\Models\UserNotificationSettings;

class CreateUserMetadata
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $userId = $event->user->id;
        UserActivity::firstOrCreate(['user_id' => $userId]);
        UserNotificationSettings::firstOrCreate(['user_id' => $userId]);
    }
}
