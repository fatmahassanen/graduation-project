<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'event_date',
        'location',
        'image',
        'link',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}
