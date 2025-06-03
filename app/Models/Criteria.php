<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function evaluations()
    {
        return $this->hasMany(CriteriaEvaluation::class);
    }
}
