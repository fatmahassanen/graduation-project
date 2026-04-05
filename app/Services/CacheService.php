<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache TTL in seconds (1 hour)
     */
    protected int $ttl = 3600;

    /**
     * Cache a page by slug and language
     */
    public function cachePage(string $slug, string $language, mixed $data): void
    {
        $key = $this->getPageCacheKey($slug, $language);
        Cache::put($key, $data, $this->ttl);
    }

    /**
     * Get cached page by slug and language
     */
    public function getCachedPage(string $slug, string $language): mixed
    {
        $key = $this->getPageCacheKey($slug, $language);
        return Cache::get($key);
    }

    /**
     * Invalidate page cache by slug
     */
    public function invalidatePageCache(string $slug, ?string $language = null): void
    {
        if ($language) {
            // Invalidate specific language version
            $key = $this->getPageCacheKey($slug, $language);
            Cache::forget($key);
        } else {
            // Invalidate all language versions
            $languages = ['en', 'ar'];
            foreach ($languages as $lang) {
                $key = $this->getPageCacheKey($slug, $lang);
                Cache::forget($key);
            }
        }
    }

    /**
     * Cache a reusable content block
     */
    public function cacheBlock(int $blockId, mixed $data): void
    {
        $key = $this->getBlockCacheKey($blockId);
        Cache::put($key, $data, $this->ttl);
    }

    /**
     * Get cached content block
     */
    public function getCachedBlock(int $blockId): mixed
    {
        $key = $this->getBlockCacheKey($blockId);
        return Cache::get($key);
    }

    /**
     * Invalidate content block cache
     */
    public function invalidateBlockCache(int $blockId): void
    {
        $key = $this->getBlockCacheKey($blockId);
        Cache::forget($key);
    }

    /**
     * Invalidate all caches related to a page
     */
    public function invalidatePageRelatedCaches(int $pageId): void
    {
        // This would invalidate page cache and all its content blocks
        // For now, we'll use a tag-based approach if Redis is available
        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            Cache::tags(['page:' . $pageId])->flush();
        }
    }

    /**
     * Clear all page caches
     */
    public function clearAllPageCaches(): void
    {
        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            Cache::tags(['pages'])->flush();
        } else {
            // Fallback: clear entire cache (not recommended for production)
            Cache::flush();
        }
    }

    /**
     * Generate cache key for a page
     */
    protected function getPageCacheKey(string $slug, string $language): string
    {
        return "page:{$slug}:{$language}";
    }

    /**
     * Generate cache key for a content block
     */
    protected function getBlockCacheKey(int $blockId): string
    {
        return "block:{$blockId}";
    }

    /**
     * Set custom TTL
     */
    public function setTtl(int $seconds): self
    {
        $this->ttl = $seconds;
        return $this;
    }

    /**
     * Get current TTL
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }
}
