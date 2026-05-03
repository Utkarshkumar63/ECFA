<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'medal_type', // Gold, Silver, Bronze
        'level',      // National, State, District
        'event_name',
        'image',      // Cloudinary URL
        'user_id',
        'achievement_date'
    ];

    /**
     * Relationship: An achievement belongs to an athlete.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
