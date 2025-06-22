<?php

namespace App\Helpers;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class CommentHelper
{
    const COMMENTABLE = [
        Event::class,
        Restaurant::class,
        User::class,
        Visit::class,
    ];

    const PER_PAGE = 30;

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
                'preamble' => __('comments.to_visit'),
                'href' => RouteHelper::show($commentable),
                'text' => $commentable->datetime,
            ];
        return null;
    }

    public static function getRoute(Comment $comment)
    {
        return RouteHelper::show($comment->commentable_type, $comment->commentable_id);
    }
}
