<?php

namespace App\Notifications;

use App\Helpers\CommentHelper;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class CommentReplyCreated extends Notification
{
    private Comment $comment;

    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(User $user)
    {
        $comment = $this->comment;
        return TelegramMessage::create()
            ->to($user->tg_id)
            ->content('💬 [' . $comment->user->name . '](' . route('users.show', $comment->user->id) . ') отвечает на ваш комментарий:')
            ->line('')
            ->line($comment->text)
            ->button('Перейти', route(CommentHelper::COMMENTABLE_VIEWS[$comment->commentable_type], $comment->commentable_id));
    }

    public static function tryNotify(Comment $comment): bool
    {
        if ($parentId = $comment->parent_id) {
            if ($parent = Comment::where('id', $parentId)->first()) {
                $parent->user->notify(new CommentReplyCreated($comment));
                return true;
            }
        }
        return false;
    }
}
