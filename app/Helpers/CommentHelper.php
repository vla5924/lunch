<?php

namespace App\Helpers;

use App\Models\Comment;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class CommentHelper
{
    const PER_PAGE = 50;

    public static function canEdit(Comment $comment)
    {
        return PermissionHelper::canActOwned('edit all comments', 'edit owned comments', $comment->user_id);
    }

    public static function canDelete(Comment $comment)
    {
        return PermissionHelper::canActOwned('delete all comments', 'delete owned comments', $comment->user_id);
    }

    public static function getExternal(Comment $comment, Model $base)
    {
        $commentable = $comment->commentable;
        $externalClass = get_class($commentable);
        if ($externalClass == get_class($base))
            return null;
        if ($externalClass == Visit::class)
            return [
                'preamble' => 'к посещению',
                'href' => route('visits.show', $commentable->id),
                'text' => $commentable->datetime,
            ];
        return null;
    }
}
