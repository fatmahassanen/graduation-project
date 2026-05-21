<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Training Model
 *
 * Represents a training program with support for up to 4 images.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $image1
 * @property string|null $image2
 * @property string|null $image3
 * @property string|null $image4
 * @property string|null $instructor
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string|null $location
 * @property int|null $duration
 * @property int|null $capacity
 * @property string|null $category
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Training extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'image1',
        'image2',
        'image3',
        'image4',
        'instructor',
        'start_date',
        'end_date',
        'location',
        'duration',
        'capacity',
        'category',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get all non-null images as an array.
     *
     * @return array<string>
     */
    public function getAllImages(): array
    {
        return array_filter([
            $this->image1,
            $this->image2,
            $this->image3,
            $this->image4,
        ]);
    }
}
