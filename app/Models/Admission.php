<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Admission Model
 *
 * Manages student admission applications with status tracking
 */
class Admission extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'national_id',
        'first_name',
        'second_name',
        'third_name',
        'fourth_name',
        'gender',
        'religion',
        'birth_date',
        'birth_governorate',
        'current_governorate',
        'city_center',
        'village_district',
        'street_address',
        'phone',
        'email',
        'student_photo',
        'birth_certificate',
        'qualification_certificate',
        'student_id_document',
        'parent_name',
        'parent_phone',
        'father_occupation',
        'parent_id_document',
        'status',
        'current_step',
        'student_code',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the full name of the student.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->second_name} {$this->third_name} {$this->fourth_name}";
    }

    /**
     * Get the user who submitted this admission application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviewer (admin user) who processed this application.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include pending applications.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted applications.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include rejected applications.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include draft applications.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Check if the application is a draft.
     *
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if the application is submitted (not draft).
     *
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return in_array($this->status, ['pending', 'accepted', 'rejected']);
    }

    /**
     * Resolve a public URL for a stored admission file path.
     *
     * Handles mixed storage conventions:
     * - uploads/filename.jpg  → public/uploads (direct asset)
     * - admissions/documents/file.pdf → storage disk via storage symlink
     * - public/… or storage/… prefixes are stripped to avoid duplicated segments
     */
    public function fileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');
        $normalized = preg_replace('#^(?:public/|storage/)+#', '', $normalized);

        if (str_starts_with($normalized, 'uploads/') || str_starts_with($normalized, 'img/')) {
            return asset($normalized);
        }

        return asset('storage/'.$normalized);
    }
}
