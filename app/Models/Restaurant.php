<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function bans()
    {
        return $this->hasMany(BannedRestaurant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function visitComments()
    {
        return $this->hasManyThrough(
            Comment::class,
            Visit::class,
            'restaurant_id',
            'commentable_id',
            'id',
            'id'
        )->where('comments.commentable_type', Visit::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
