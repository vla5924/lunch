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

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;
        if ($parent = Comment::find($comment->parent_id)) {
            $parent->user->notify(new CommentReplyCreated($comment)->delay(self::WAIT_BEFORE_SEND));
            return;
        }
        $user = $comment->commentable;
        if (get_class($user) == User::class) {
            $user->notify(new UserCommentCreated($comment)->delay(self::WAIT_BEFORE_SEND));
            return;
        }
    }
}
