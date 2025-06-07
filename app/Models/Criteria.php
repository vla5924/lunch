<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Criteria extends Model
{
    public function getNameAttribute()
    {
        if (Auth::user()->locale == 'ru')
            return $this->name_ru;
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (Auth::user()->locale == 'ru')
            return $this->description_ru;
        return $this->description_en;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function evaluations()
    {
        return $this->hasMany(CriteriaEvaluation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
