<?php

namespace App\Models;

use App\Events\UserCreated;
use App\Events\UserDeleting;
use App\Helpers\UserActivityHelper;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasLocalePreference
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'deleting' => UserDeleting::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tg_id',
        'tg_name',
        'tg_username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => AsArrayObject::class,
        ];
    }

    public function getAvaAttribute()
    {
        return $this->avatar ?? config('lunch.fallback_avatar');
    }

    public function getNameAttribute()
    {
        return $this->display_name ?? $this->tg_name;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getOnlineAtAttribute()
    {
        return UserActivityHelper::getOnline($this->id);
    }

    /**
     * Get the user's preferred locale.
     */
    public function preferredLocale(): string
    {
        return $this->locale;
    }
}
