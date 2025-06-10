<?php

namespace App\Models;

use App\Helpers\EvaluationHelper;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    public function criterias()
    {
        return $this->hasMany(CriteriaEvaluation::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalfAttribute()
    {
        return EvaluationHelper::formatTotal($this->total);
    }
}
