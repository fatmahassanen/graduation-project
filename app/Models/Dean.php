<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dean extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'title',
        'position',
        'faculty',
        'image',
        'welcome_text',
        'education',
        'experience',
        'order',
    ];
}
