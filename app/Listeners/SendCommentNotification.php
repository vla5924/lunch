<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentReplyCreated;
use App\Notifications\UserCommentCreated;

class SendCommentNotification
{
    const WAIT_BEFORE_SEND = 30;

    // This may be set to true when debugging
    private bool $allowSelfNotify = false;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    private function shouldNotify(Comment $comment, User $recipient, ?string $setting = null): bool
    {
        if (!$recipient->can('view comments'))
            return false;
        if ($setting && !$recipient->notificationSettings->$setting)
            return false;
        return $this->allowSelfNotify || $comment->user_id != $recipient->id;
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;
        $parentUser = null;
        if ($parent = Comment::find($comment->parent_id)) {
            $parentUser = $parent->user;
            if ($this->shouldNotify($comment, $parentUser, 'comment_reply'))
                $parent->user->notify(new CommentReplyCreated($comment)->delay(self::WAIT_BEFORE_SEND));
        }
        $user = $comment->commentable;
        if (get_class($user) == User::class) {
            /**
             * @var \App\Models\User $user
             */
            if ($this->shouldNotify($comment, $user, 'profile_comment') && $user->id != ($parentUser ? $parentUser->id : null))
                $user->notify(new UserCommentCreated($comment)->delay(self::WAIT_BEFORE_SEND));
        }
    }
}
