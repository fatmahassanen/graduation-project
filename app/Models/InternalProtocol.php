<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalProtocol extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'organization_name',
        'image',
        'year',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'year' => 'integer',
    ];
}
