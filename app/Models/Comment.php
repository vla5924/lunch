<?php

namespace App\Models;

use App\Events\CommentCreated;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'saved' => CommentCreated::class,
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
