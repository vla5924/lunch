<?php

namespace App\Helpers;

use App\Models\BannedRestaurant;
use App\Models\Comment;
use App\Models\Criteria;
use App\Models\CriteriaEvaluation;
use App\Models\Evaluation;
use App\Models\Event;
use App\Models\Restaurant;
use App\Models\RestaurantScore;
use App\Models\TelegramNotification;
use App\Models\User;
use App\Models\Visit;
use App\Notifications\CommentReplyCreated;
use App\Notifications\UserCommentCreated;
use App\Notifications\VisitPlanned;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DeleteHelper
{
    public static function deleteComment(Comment $comment)
    {
        Comment::where('parent_id', $comment->id)->update(['parent_id' => $comment->parent_id]);
        $notifications = DB::table('notifications')
            ->where('notifiable_type', User::class)
            ->whereIn('type', [CommentReplyCreated::class, UserCommentCreated::class])
            ->whereJsonContains('data->comment_id', $comment->id);
        self::deleteNotifications($notifications);
        $comment->delete();
    }

    public static function deleteCriteria(Criteria $criteria)
    {
        CriteriaEvaluation::where('criteria_id', $criteria->id)->delete();
        $criteria->categories()->detach();
        $criteria->delete();
    }

    public static function deleteEvaluation(Evaluation $evaluation)
    {
        foreach ($evaluation->criterias as $ce) {
            $ce->delete();
        }
        $evaluation->delete();
    }

    public static function deleteEvent(Event $event)
    {
        self::deleteRelatedComments($event);
        $event->delete();
    }

    public static function deleteNotifications(Builder $query)
    {
        foreach ($query->get(['id']) as $notification) {
            TelegramNotification::where('notification_id', $notification->id)->delete();
        }
        $query->delete();
    }

    public static function deleteRelatedComments(Model $commentable)
    {
        $comments = Comment::query()
            ->where('commentable_id', $commentable->id)
            ->where('commentable_type', get_class($commentable))
            ->get();
        foreach ($comments as $comment)
            self::deleteComment($comment);
    }

    public static function deleteRestaurant(Restaurant $restaurant)
    {
        self::deleteRelatedComments($restaurant);
        foreach ($restaurant->evaluations as $evaluation)
            self::deleteEvaluation($evaluation);
        foreach ($restaurant->visits as $visit)
            self::deleteVisit($visit);
        BannedRestaurant::where('restaurant_id', $restaurant->id)->delete();
        RestaurantScore::where('restaurant_id', $restaurant->id)->delete();
        $restaurant->delete();
    }

    public static function deleteVisit(Visit $visit)
    {
        self::deleteRelatedComments($visit);
        $notifications = DB::table('notifications')
            ->where('notifiable_type', User::class)
            ->where('type', VisitPlanned::class)
            ->whereJsonContains('data->visit_id', $visit->id);
        self::deleteNotifications($notifications);
        $visit->delete();
    }
}
