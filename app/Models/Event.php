<?php

namespace App\Models;

use App\Helpers\EventHelper;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateAttribute(): string
    {
        $day = "{$this->day} ";
        $month = EventHelper::monthLang($this->month);
        $year = $this->year ? " {$this->year}" : '';
        return "$day$month$year";
    }
}
