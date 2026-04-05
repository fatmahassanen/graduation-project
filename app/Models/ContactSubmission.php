<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'is_read',
        'read_by',
        'read_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user who read the submission.
     */
    public function reader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'read_by');
    }

    /**
     * Scope a query to only include unread submissions.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read submissions.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Mark the submission as read by a user.
     */
    public function markAsRead(int $userId): void
    {
        $this->update([
            'is_read' => true,
            'read_by' => $userId,
            'read_at' => now(),
        ]);
    }
}
