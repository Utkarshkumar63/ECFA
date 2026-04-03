<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'image',
        'type',
        'created_by',
        'published_date',
        'is_published',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * Get the user who created this news.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for published news only
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
