<?php

namespace App\Policies;

use App\Models\ContentBlock;
use App\Models\User;

class ContentBlockPolicy
{
    /**
     * Determine if the user can view any content blocks.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view content blocks list
        return true;
    }

    /**
     * Determine if the user can view the content block.
     */
    public function view(User $user, ContentBlock $block): bool
    {
        // Super admins can view all content blocks
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Faculty admins can only view content blocks for pages in their faculty category
        if ($user->isFacultyAdmin()) {
            return $block->page && $block->page->category === $user->faculty_category;
        }

        // Content editors can view all content blocks
        if ($user->isContentEditor()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can create content blocks.
     */
    public function create(User $user): bool
    {
        // All roles can create content
        return $user->isSuperAdmin() || $user->isContentEditor() || $user->isFacultyAdmin();
    }

    /**
     * Determine if the user can update the content block.
     */
    public function update(User $user, ContentBlock $block): bool
    {
        // Super admins can edit all content blocks
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Faculty admins can only edit content blocks for pages in their faculty category
        if ($user->isFacultyAdmin()) {
            return $block->page && $block->page->category === $user->faculty_category;
        }

        // Content editors can edit all content blocks
        if ($user->isContentEditor()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the content block.
     */
    public function delete(User $user, ContentBlock $block): bool
    {
        // Only super admins can delete content
        return $user->isSuperAdmin();
    }
}
