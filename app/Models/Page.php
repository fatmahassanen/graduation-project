<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'meta_description',
        'meta_keywords',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the sections for the page.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('section_order');
    }
}
