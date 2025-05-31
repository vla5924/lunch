<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public function criteria_evaluations()
    {
        return $this->belongsToMany(CriteriaEvaluation::class);
    }
}
