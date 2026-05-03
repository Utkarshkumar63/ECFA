<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Event;
use App\Models\Achievement; // Import Achievement model

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'category',
        'role',
        'is_approved',
        'dob',
        'gender',
        'address',
        'city',
        'state',
        'pincode',
        'age_group',
        'experience',
        'events',
        // --- Identity Verification Fields (New) ---
        'aadhar_no',
        'aadhar_photo',
        'dob_photo',
        'passport_no',
        'passport_photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'events' => 'array', // Checkboxes ke liye zaroori hai
        ];
    }

    /**
     * Relationship: Tournaments joined by the player
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Relationship: Player's achievements and medals
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'user_id');
    }
}
