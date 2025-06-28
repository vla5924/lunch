<?php

namespace App\Notifications;

use App\Helpers\CommentHelper;
use App\Helpers\RouteHelper;
use App\Helpers\TelegramHelper;
use App\Models\Comment;
use App\Models\User;
use NotificationChannels\Telegram\TelegramMessage;

class CommentReplyCreated extends CommentNotification
{
    public function toDatabase(User $user): array
    {
        return [
            'comment_id' => $this->comment->id,
        ];
    }

    public function toTelegram(User $user)
    {
        $message = __('notifications.replied_to_your_comment', [
            'user' => TelegramHelper::modelLink($this->comment->user),
        ]);
        return TelegramMessage::create()
            ->to($user->tg_id)
            ->content('💬 ' . $message . PHP_EOL)
            ->line($this->comment->text)
            ->button(__('notifications.open'), RouteHelper::show($this->comment->commentable));
    }
}
