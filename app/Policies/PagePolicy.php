<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    /**
     * Determine if the user can view any pages.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view pages list
        return true;
    }

    /**
     * Determine if the user can view the page.
     */
    public function view(User $user, Page $page): bool
    {
        // Super admins can view all pages
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Faculty admins can only view pages in their faculty category
        if ($user->isFacultyAdmin()) {
            return $page->category === $user->faculty_category;
        }

        // Content editors can view all pages
        if ($user->isContentEditor()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can create pages.
     */
    public function create(User $user): bool
    {
        // All roles can create content
        return $user->isSuperAdmin() || $user->isContentEditor() || $user->isFacultyAdmin();
    }

    /**
     * Determine if the user can update the page.
     */
    public function update(User $user, Page $page): bool
    {
        // Super admins can edit all pages
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Faculty admins can only edit pages in their faculty category
        if ($user->isFacultyAdmin()) {
            return $page->category === $user->faculty_category;
        }

        // Content editors can edit all pages
        if ($user->isContentEditor()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can delete the page.
     */
    public function delete(User $user, Page $page): bool
    {
        // Only super admins can delete content
        return $user->isSuperAdmin();
    }

    /**
     * Determine if the user can publish the page.
     */
    public function publish(User $user, Page $page): bool
    {
        // Only super admins can publish content
        return $user->isSuperAdmin();
    }

    /**
     * Determine if the user can restore the page.
     */
    public function restore(User $user, Page $page): bool
    {
        // Only super admins can restore revisions
        return $user->isSuperAdmin();
    }
}
