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
}
