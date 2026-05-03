<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\LearnMaterial;
use App\Models\User;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'image',
        'status'

    ];

    /**
     * Relationship: An event has many learning materials.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(LearnMaterial::class);
    }

 public function userCertificate()
{
    return $this->hasOne(Certificate::class, 'event_name', 'title')
                ->where('user_id', auth()->id());
}
public function athletes()
{
    // FIX: added 'attendance_status' and 'absent_reason' to withPivot
    return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')
                ->withPivot('status', 'attendance_status', 'absent_reason')
                ->withTimestamps();
}

}
