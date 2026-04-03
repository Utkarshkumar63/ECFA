<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventParticipant extends Pivot
{
    protected $table = 'event_participants';

    protected $fillable = [
        'event_id',
        'player_id',
        'status',
        'position',
    ];
}
