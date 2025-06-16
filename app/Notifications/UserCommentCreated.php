<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class UserCommentCreated extends Notification
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
            ->content('💬 [' . $comment->user->name . '](' . route('users.show', $comment->user->id) . ') оставляет комментарий у вас в профиле:')
            ->line('')
            ->line($comment->text)
            ->button('Перейти', route('users.show', $user->id));
    }

    public static function tryNotify(Comment $comment): bool
    {
        $user = $comment->commentable;
        if (get_class($user) != User::class)
            return false;
        $user->notify(new UserCommentCreated($comment));
        return true;
    }
}
