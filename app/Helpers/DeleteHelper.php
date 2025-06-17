<?php

namespace App\Helpers;

use App\Models\BannedRestaurant;
use App\Models\Comment;
use App\Models\Criteria;
use App\Models\CriteriaEvaluation;
use App\Models\Evaluation;
use App\Models\Group;
use App\Models\Restaurant;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;

class DeleteHelper
{
    public static function deleteComment(Comment $comment)
    {
        Comment::where('parent_id', $comment->id)->update(['parent_id' => $comment->parent_id]);
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

    public static function deleteGroup(Group $group)
    {
        $group->users()->detach();
        $group->delete();
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
        $restaurant->delete();
    }

    public static function deleteVisit(Visit $visit)
    {
        self::deleteRelatedComments($visit);
        $visit->delete();
    }
}
