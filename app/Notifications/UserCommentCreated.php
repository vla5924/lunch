<?php

namespace App\Notifications;

use App\Helpers\TelegramHelper;
use App\Models\Comment;
use App\Models\User;
use NotificationChannels\Telegram\TelegramMessage;

class UserCommentCreated extends CommentNotification
{
    public function toDatabase(User $user): array
    {
        return [
            'comment_id' => $this->comment->id,
        ];
    }

    public function toTelegram(User $user)
    {
        $message = __('notifications.left_comment_in_your_profile', [
            'user' => TelegramHelper::modelLink($this->comment->user),
        ]);
        return TelegramMessage::create()
            ->to($user->tg_id)
            ->content('📥 ' . $message . PHP_EOL)
            ->line($this->comment->text)
            ->button(__('notifications.open'), route('users.show', $user->id));
    }
}
