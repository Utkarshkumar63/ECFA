<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'address',
        'category',
        'event_type',
        'bio',
        'profile_image',
        'emergency_contact',
        'emergency_phone',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    protected $appends = ['age'];

    /**
     * Get the achievements for the player.
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * Get the events the player has participated in.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_participants')
            ->withPivot('status', 'position')
            ->withTimestamps();
    }

    /**
     * Get player's age calculated from DOB
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }
}
