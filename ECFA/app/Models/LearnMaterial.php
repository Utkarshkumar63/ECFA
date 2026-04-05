<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearnMaterial extends Model
{
    protected $fillable = [
        'event_id',
        'weapon',
        'title',
        'file_path',
        'original_filename',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
