<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotResponse extends Model
{
    protected $fillable = [
        'keyword',
        'reply',
    ];
}
