<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Testimonial Model
 *
 * Represents a graduate success story or testimonial.
 *
 * @property int $id
 * @property string $student_name
 * @property string|null $department
 * @property string|null $photo
 * @property string $testimonial
 * @property int $order
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Testimonial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'student_name',
        'department',
        'photo',
        'testimonial',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
