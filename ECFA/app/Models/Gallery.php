<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Laravel 'galleries' naam ki table khud dhoond lega.
     */
    protected $table = 'galleries';

    /**
     * The attributes that are mass assignable.
     * 'url' mein hum Cloudinary ka secure path save karenge.
     */
    protected $fillable = [
        'title',
        'url',
        'category',
        'description',
    ];
}
