<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'cert_id', 'user_id', 'event_id', 'event_name', 'verification_hash', 'issue_date', 'medal_type','location', 'host_org', 
    ];

     protected $casts = [
        'issue_date' => 'datetime',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
