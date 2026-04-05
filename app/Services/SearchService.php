<?php

namespace App\Services;

use App\Models\Event;
use App\Models\News;
use App\Models\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SearchService
{
    /**
     * Search across pages, news, and events.
     */
    public function search(string $query, array $filters = []): Collection
    {
        $results = collect();

        // Extract filters
        $category = $filters['category'] ?? null;
        $language = $filters['language'] ?? app()->getLocale();
        $contentType = $filters['content_type'] ?? null;

        // Search pages if no content type filter or if pages are requested
        if (!$contentType || $contentType === 'pages') {
            $pageResults = $this->searchPages($query, $language, $category);
            $results = $results->merge($pageResults);
        }

        // Search news if no content type filter or if news are requested
        if (!$contentType || $contentType === 'news') {
            $newsResults = $this->searchNews($query, $language, $category);
            $results = $results->merge($newsResults);
        }

        // Search events if no content type filter or if events are requested
        if (!$contentType || $contentType === 'events') {
            $eventResults = $this->searchEvents($query, $language, $category);
            $results = $results->merge($eventResults);
        }

        // Sort by relevance score (descending)
        $results = $results->sortByDesc('relevance_score')->values();

        // Log the search query
        $this->logSearchQuery($query, $results->count(), $filters);

        return $results;
    }

    /**
     * Search pages using fulltext search.
     */
    protected function searchPages(string $query, string $language, ?string $category): Collection
    {
        $pagesQuery = Page::where('status', 'published')
            ->where('language', $language);

        if ($category) {
            $pagesQuery->where('category', $category);
        }

        // Use fulltext search if available, otherwise use LIKE
        if ($this->supportsFulltext()) {
            $pagesQuery->whereRaw(
                "MATCH(title, meta_description) AGAINST(? IN NATURAL LANGUAGE MODE)",
                [$query]
            );
        } else {
            $pagesQuery->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('meta_description', 'LIKE', "%{$query}%")
                  ->orWhere('meta_keywords', 'LIKE', "%{$query}%");
            });
        }

        return $pagesQuery->get()->map(function ($page) use ($query) {
            return [
                'type' => 'page',
                'id' => $page->id,
                'title' => $page->title,
                'excerpt' => $page->meta_description ?? '',
                'url' => route('page.show', ['slug' => $page->slug]),
                'relevance_score' => $this->calculateRelevanceScore($query, $page->title, $page->meta_description ?? ''),
                'highlighted_title' => $this->highlightSearchTerms($query, $page->title),
                'highlighted_excerpt' => $this->highlightSearchTerms($query, $page->meta_description ?? ''),
            ];
        });
    }

    /**
     * Search news articles using fulltext search.
     */
    protected function searchNews(string $query, string $language, ?string $category): Collection
    {
        $newsQuery = News::where('status', 'published')
            ->where('language', $language);

        if ($category) {
            $newsQuery->where('category', $category);
        }

        // Use fulltext search if available
        if ($this->supportsFulltext()) {
            $newsQuery->whereRaw(
                "MATCH(title, excerpt, body) AGAINST(? IN NATURAL LANGUAGE MODE)",
                [$query]
            );
        } else {
            $newsQuery->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%")
                  ->orWhere('body', 'LIKE', "%{$query}%");
            });
        }

        return $newsQuery->get()->map(function ($news) use ($query) {
            // Use route if it exists, otherwise use a placeholder URL
            $url = \Route::has('news.show') 
                ? route('news.show', ['slug' => $news->slug])
                : url('/news/' . $news->slug);

            return [
                'type' => 'news',
                'id' => $news->id,
                'title' => $news->title,
                'excerpt' => $news->excerpt,
                'url' => $url,
                'relevance_score' => $this->calculateRelevanceScore($query, $news->title, $news->excerpt),
                'highlighted_title' => $this->highlightSearchTerms($query, $news->title),
                'highlighted_excerpt' => $this->highlightSearchTerms($query, $news->excerpt),
            ];
        });
    }

    /**
     * Search events.
     */
    protected function searchEvents(string $query, string $language, ?string $category): Collection
    {
        $eventsQuery = Event::where('status', 'published')
            ->where('language', $language);

        if ($category) {
            $eventsQuery->where('category', $category);
        }

        $eventsQuery->where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('location', 'LIKE', "%{$query}%");
        });

        return $eventsQuery->get()->map(function ($event) use ($query) {
            // Use route if it exists, otherwise use a placeholder URL
            $url = \Route::has('events.show') 
                ? route('events.show', ['id' => $event->id])
                : url('/events/' . $event->id);

            return [
                'type' => 'event',
                'id' => $event->id,
                'title' => $event->title,
                'excerpt' => substr($event->description, 0, 200) . '...',
                'url' => $url,
                'relevance_score' => $this->calculateRelevanceScore($query, $event->title, $event->description),
                'highlighted_title' => $this->highlightSearchTerms($query, $event->title),
                'highlighted_excerpt' => $this->highlightSearchTerms($query, substr($event->description, 0, 200)),
            ];
        });
    }

    /**
     * Calculate relevance score based on query matches.
     */
    protected function calculateRelevanceScore(string $query, string $title, string $content): float
    {
        $score = 0.0;
        $queryLower = strtolower($query);
        $titleLower = strtolower($title);
        $contentLower = strtolower($content);

        // Exact match in title gets highest score
        if ($titleLower === $queryLower) {
            $score += 100;
        }

        // Title contains query
        if (str_contains($titleLower, $queryLower)) {
            $score += 50;
        }

        // Content contains query
        if (str_contains($contentLower, $queryLower)) {
            $score += 10;
        }

        // Count occurrences in title (weighted more)
        $titleOccurrences = substr_count($titleLower, $queryLower);
        $score += $titleOccurrences * 20;

        // Count occurrences in content
        $contentOccurrences = substr_count($contentLower, $queryLower);
        $score += $contentOccurrences * 5;

        return $score;
    }

    /**
     * Highlight search terms in text.
     */
    protected function highlightSearchTerms(string $query, string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // Escape special regex characters in query
        $escapedQuery = preg_quote($query, '/');

        // Highlight matches (case-insensitive)
        return preg_replace(
            "/({$escapedQuery})/i",
            '<mark class="search-highlight">$1</mark>',
            $text
        );
    }

    /**
     * Log search query for analytics.
     */
    protected function logSearchQuery(string $query, int $resultsCount, array $filters): void
    {
        DB::table('search_logs')->insert([
            'query' => $query,
            'results_count' => $resultsCount,
            'filters' => json_encode($filters),
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }

    /**
     * Check if database supports fulltext search.
     */
    protected function supportsFulltext(): bool
    {
        // Check if we're using MySQL/MariaDB
        $driver = config('database.default');
        $connection = config("database.connections.{$driver}.driver");

        return in_array($connection, ['mysql', 'mariadb']);
    }
}
