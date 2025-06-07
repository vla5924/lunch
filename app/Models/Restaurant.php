<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
