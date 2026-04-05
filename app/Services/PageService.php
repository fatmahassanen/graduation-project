<?php

namespace App\Services;

use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PageService
{
    public function __construct(
        protected CacheService $cacheService
    ) {
    }

    /**
     * Get a published page by slug and language with caching.
     */
    public function getPublishedPageBySlug(string $slug, string $language): ?Page
    {
        // Don't cache models with relationships to avoid serialization issues
        // Instead, query directly each time (still fast with proper indexing)
        return Page::where('slug', $slug)
            ->where('language', $language)
            ->where('status', 'published')
            ->with('contentBlocks')
            ->first();
    }

    /**
     * Create a new page.
     */
    public function createPage(array $data, User $user): Page
    {
        // Generate slug if not provided
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title']);
        }

        // Set creator
        $data['created_by'] = $user->id;

        // Create the page
        $page = Page::create($data);

        // Create revision for the creation
        $this->createRevision($page, [], $page->toArray(), $user, 'created');

        return $page;
    }

    /**
     * Update an existing page.
     */
    public function updatePage(Page $page, array $data, User $user): Page
    {
        // Capture old values for revision and cache invalidation
        $oldValues = $page->toArray();
        $oldSlug = $page->slug;
        $oldLanguage = $page->language;

        // Update slug if title changed and slug not explicitly provided
        if (isset($data['title']) && $data['title'] !== $page->title) {
            if (!isset($data['slug']) || empty($data['slug'])) {
                $data['slug'] = $this->generateUniqueSlug($data['title'], $page->id);
            }
        }

        // Set updater
        $data['updated_by'] = $user->id;

        // Update the page
        $page->update($data);
        $page->refresh();

        // Invalidate cache using OLD slug and language (before the update)
        $this->cacheService->invalidatePageCache($oldSlug, $oldLanguage);
        
        // If slug or language changed, also invalidate the new cache key
        if ($page->slug !== $oldSlug || $page->language !== $oldLanguage) {
            $this->cacheService->invalidatePageCache($page->slug, $page->language);
        }

        // Create revision for the update
        $this->createRevision($page, $oldValues, $page->toArray(), $user, 'updated');

        return $page;
    }

    /**
     * Publish a page.
     */
    public function publishPage(Page $page, User $user): Page
    {
        $oldValues = $page->toArray();

        $page->update([
            'status' => 'published',
            'published_at' => now(),
            'updated_by' => $user->id,
        ]);

        $page->refresh();

        // Invalidate cache for this page
        $this->cacheService->invalidatePageCache($page->slug, $page->language);

        $this->createRevision($page, $oldValues, $page->toArray(), $user, 'published');

        return $page;
    }

    /**
     * Unpublish a page (set to draft).
     */
    public function unpublishPage(Page $page, User $user): Page
    {
        $oldValues = $page->toArray();

        $page->update([
            'status' => 'draft',
            'updated_by' => $user->id,
        ]);

        $page->refresh();

        // Invalidate cache for this page
        $this->cacheService->invalidatePageCache($page->slug, $page->language);

        $this->createRevision($page, $oldValues, $page->toArray(), $user, 'unpublished');

        return $page;
    }

    /**
     * Archive a page.
     */
    public function archivePage(Page $page, User $user): Page
    {
        $oldValues = $page->toArray();

        $page->update([
            'status' => 'archived',
            'updated_by' => $user->id,
        ]);

        $page->refresh();

        // Invalidate cache for this page
        $this->cacheService->invalidatePageCache($page->slug, $page->language);

        $this->createRevision($page, $oldValues, $page->toArray(), $user, 'updated');

        return $page;
    }

    /**
     * Get pages by category and language.
     */
    public function getPagesByCategory(string $category, string $language): Collection
    {
        return Page::where('category', $category)
            ->where('language', $language)
            ->where('status', 'published')
            ->orderBy('title')
            ->get();
    }

    /**
     * Generate a unique slug from a title.
     */
    public function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        // Generate base slug from title
        $baseSlug = Str::slug($title);

        // Check if slug is unique
        $slug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if a slug exists (excluding a specific page ID).
     */
    protected function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Page::where('slug', $slug);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Create a revision record for a page.
     */
    protected function createRevision(Page $page, array $oldValues, array $newValues, User $user, string $action): void
    {
        $page->revisions()->create([
            'user_id' => $user->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'created_at' => now(),
        ]);
    }
}
