<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

abstract class CommentNotification extends Notification implements ShouldQueue
{
    protected Comment $comment;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'telegram'];
    }

    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(object $notifiable, string $channel): bool
    {
        return Comment::find($this->comment->id) != null;
    }

    abstract public function toDatabase(User $user): array;

    abstract public function toTelegram(User $user);
}
