<?php

namespace App\Models;

use App\Helpers\EvaluationHelper;
use Illuminate\Database\Eloquent\Model;

class RestaurantScore extends Model
{
    protected $primaryKey = 'restaurant_id';

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getScorefAttribute()
    {
        return EvaluationHelper::formatTotal($this->score);
    }
}
