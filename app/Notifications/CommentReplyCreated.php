<?php

namespace App\Notifications;

use App\Helpers\CommentHelper;
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
        $comment = $this->comment;
        $userLink = '[' . $comment->user->name . '](' . route('users.show', $comment->user->id) . ')';
        $info = __('notifications.replied_to_your_comment');
        return TelegramMessage::create()
            ->to($user->tg_id)
            ->content("💬 {$userLink} {$info}:\n")
            ->line($comment->text)
            ->button(__('notifications.open'), route(CommentHelper::COMMENTABLE_VIEWS[$comment->commentable_type], $comment->commentable_id));
    }
}
