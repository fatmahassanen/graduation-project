<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresidentContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'title',
        'position',
        'image',
        'welcome_text',
        'education',
        'postdoctoral',
        'administrative',
    ];
}
