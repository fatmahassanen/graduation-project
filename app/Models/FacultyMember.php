<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacultyMember extends Model
{
    protected $fillable = [
        'name',
        'position',
        'department_id',
        'bio',
        'photo',
        'email',
        'phone',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the department that owns the faculty member.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
