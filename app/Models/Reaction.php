<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }
}
