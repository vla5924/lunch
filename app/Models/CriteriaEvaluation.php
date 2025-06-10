<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaEvaluation extends Model
{
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function getPercentageAttribute()
    {
        $criteria = $this->criteria;
        $min = $criteria->min_value;
        if ($min != 0)
            $min -= 1;
        return floor(($this->value - $min) / ($criteria->max_value - $min) * 100);
    }
}
