<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * TuitionFee Model
 *
 * Represents tuition fee structure for different year ranges.
 *
 * @property int $id
 * @property string $year_range
 * @property float $amount
 * @property int $order
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TuitionFee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'year_range',
        'amount',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
