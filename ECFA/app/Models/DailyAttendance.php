<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
 protected $fillable = ['user_id', 'attendance_date', 'status','marked_by'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
