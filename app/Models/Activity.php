<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full image URL for display.
     * Handles both storage paths (uploaded images) and public paths (seeded images).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        // If image starts with 'activities/', it's in storage
        if (str_starts_with($this->image, 'activities/')) {
            return asset('storage/'.$this->image);
        }

        // Otherwise, it's a public path (seeded images)
        return asset($this->image);
    }
}
