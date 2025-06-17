<?php

namespace App\Notifications;

use App\Helpers\CommentHelper;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class CommentReplyCreated extends Notification implements ShouldQueue
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
        return ['database', 'telegram'];
    }

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
