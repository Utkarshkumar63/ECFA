<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $fillable = [
        'player_id',
        'title',
        'description',
        'medal',
        'level',
        'achievement_date',
        'event_name',
        'certificate_image',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    /**
     * Get the player that owns this achievement.
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
