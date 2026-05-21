<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'original_filename',
        'path',
        'mime_type',
        'size',
        'alt_text',
        'uploaded_by',
    ];

    /**
     * Get the user who uploaded the media.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
