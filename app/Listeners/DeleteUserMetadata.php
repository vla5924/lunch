<?php

namespace App\Listeners;

use App\Events\UserDeleting;
use App\Models\UserActivity;
use App\Models\UserNotificationSettings;

class DeleteUserMetadata
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
    public function handle(UserDeleting $event): void
    {
        $userId = $event->user->id;
        UserActivity::destroy($userId);
        UserNotificationSettings::destroy($userId);
    }
}
