<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationSettings extends Model
{
    protected $table = 'user_notification_settings';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id'];
    public $incrementing = false;
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
