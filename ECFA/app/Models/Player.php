<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Player extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'password',
        'address',
        'category',
        'event_type',
        'bio',
        'profile_image',
        'emergency_contact',
        'emergency_phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    protected $appends = ['age'];

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_participants')
            ->withPivot('status', 'position')
            ->withTimestamps();
    }

    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }
}
