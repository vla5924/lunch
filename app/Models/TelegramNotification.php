<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reply_id',
    ];
}
