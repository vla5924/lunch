<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannedRestaurant extends Model
{
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
