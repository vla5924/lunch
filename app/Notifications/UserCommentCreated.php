<?php

namespace App\Notifications;

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
        $comment = $this->comment;
        $userLink = '[' . $comment->user->name . '](' . route('users.show', $comment->user->id) . ')';
        $info = __('notifications.left_comment_in_your_profile');
        return TelegramMessage::create()
            ->to($user->tg_id)
            ->content("💬 {$userLink} {$info}:\n")
            ->line($comment->text)
            ->button(__('notifications.open'), route('users.show', $user->id));
    }
}
