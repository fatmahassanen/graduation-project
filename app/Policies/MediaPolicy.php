<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;

class MediaPolicy
{
    /**
     * Determine if the user can view any media.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view media list
        return true;
    }

    /**
     * Determine if the user can view the media.
     */
    public function view(User $user, Media $media): bool
    {
        // All authenticated users can view media
        return true;
    }

    /**
     * Determine if the user can create media.
     */
    public function create(User $user): bool
    {
        // All roles can upload media
        return $user->isSuperAdmin() || $user->isContentEditor() || $user->isFacultyAdmin();
    }

    /**
     * Determine if the user can update the media.
     */
    public function update(User $user, Media $media): bool
    {
        // Super admins can update all media
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Content editors and faculty admins can update their own media
        return $media->uploaded_by === $user->id;
    }

    /**
     * Determine if the user can delete the media.
     */
    public function delete(User $user, Media $media): bool
    {
        // Super admins can delete all media
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Content editors and faculty admins can delete their own media
        return $media->uploaded_by === $user->id;
    }
}
