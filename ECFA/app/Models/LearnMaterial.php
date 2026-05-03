<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearnMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
    'event_id',
    'title',
    'weapon',
    'file_path',
    'material_type',
    'content'  // <--- YEH HONA CHAHIYE
];

    /**
     * Relationship: A material belongs to a specific event.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
