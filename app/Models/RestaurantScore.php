<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantScore extends Model
{
    protected $primaryKey = 'restaurant_id';

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
