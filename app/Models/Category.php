<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function criterias()
    {
        return $this->belongsToMany(Criteria::class);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
