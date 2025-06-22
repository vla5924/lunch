<?php

namespace App\Listeners;

use App\Models\TelegramNotification;
use App\Notifications\CommentReplyCreated;
use App\Notifications\UserCommentCreated;
use Illuminate\Notifications\Events\NotificationSent;

class StoreTelegramNotification
{
    const HANDLABLE = [
        CommentReplyCreated::class,
        UserCommentCreated::class,
    ];

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    private function handleTelegramResponse(string $notificationId, array $response): void
    {
        if (!$response['ok'])
            return;
        $tg = new TelegramNotification;
        $tg->notification_id = $notificationId;
        $tg->chat_id = $response['result']['chat']['id'];
        $tg->message_id = $response['result']['message_id'];
        $tg->save();
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationSent $event): void
    {
        if ($event->channel != 'telegram')
            return;
        $type = get_class($event->notification);
        if (!\in_array($type, self::HANDLABLE))
            return;
        $this->handleTelegramResponse($event->notification->id, $event->response);
    }
}
