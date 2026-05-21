<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'section_key',
        'section_title',
        'section_content',
        'section_image',
        'section_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the page that owns the section.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
