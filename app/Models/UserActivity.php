<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = 'user_activity';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'online_at'];
    public $incrementing = false;
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
