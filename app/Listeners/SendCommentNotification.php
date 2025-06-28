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

    private function shouldNotify(Comment $comment, int $recipientId): bool
    {
        return $this->allowSelfNotify || $comment->user_id != $recipientId;
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;
        $parentUserId = null;
        if ($parent = Comment::find($comment->parent_id)) {
            $parentUserId = $parent->user_id;
            if ($this->shouldNotify($comment, $parentUserId))
                $parent->user->notify(new CommentReplyCreated($comment)->delay(self::WAIT_BEFORE_SEND));
        }
        $user = $comment->commentable;
        if (get_class($user) == User::class && $this->shouldNotify($comment, $user->id) && $user->id != $parentUserId) {
            $user->notify(new UserCommentCreated($comment)->delay(self::WAIT_BEFORE_SEND));
        }
    }
}
