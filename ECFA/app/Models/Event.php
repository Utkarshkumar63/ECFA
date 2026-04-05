<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'venue',
        'venue_address',
        'start_time',
        'end_time',
        'status',
        'max_participants',
        'rules',
        'event_image',
        'is_registration_open',
        'registration_end_date',
    ];

    protected $casts = [
        'event_date' => 'date',
        'registration_end_date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time',
        'is_registration_open' => 'boolean',
    ];

    /**
     * Get the participants for the event.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'event_participants')
            ->withPivot('status', 'position')
            ->withTimestamps();
    }

    /**
     * Get the gallery items for this event.
     */
    public function galleryItems(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Get the registrations for this event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function learnMaterials(): HasMany
    {
        return $this->hasMany(LearnMaterial::class);
    }

    /**
     * Scope to get only upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'Upcoming')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc');
    }

    /**
     * Scope to get completed events
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed')
            ->orderBy('event_date', 'desc');
    }
}
