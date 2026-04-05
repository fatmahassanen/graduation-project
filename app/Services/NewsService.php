<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Collection;

class NewsService
{
    /**
     * Get published news ordered by published_at descending.
     * Requirements: 14.2
     */
    public function getPublishedNews(?string $category = null, ?string $language = 'en', ?int $limit = null): Collection
    {
        $query = News::query()
            ->where('status', 'published')
            ->where('language', $language)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->with(['featuredImage', 'author']);

        if ($category) {
            $query->where('category', $category);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get related news by category.
     * Requirements: 14.6
     */
    public function getRelatedNews(News $news, int $limit = 5): Collection
    {
        return News::query()
            ->where('status', 'published')
            ->where('language', $news->language)
            ->where('category', $news->category)
            ->where('id', '!=', $news->id)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->with(['featuredImage', 'author'])
            ->get();
    }

    /**
     * Get featured news articles.
     * Requirements: 14.7
     */
    public function getFeaturedNews(?string $language = 'en', int $limit = 3): Collection
    {
        return News::query()
            ->where('status', 'published')
            ->where('language', $language)
            ->where('is_featured', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->with(['featuredImage', 'author'])
            ->get();
    }

    /**
     * Generate RSS feed for news articles.
     * Requirements: 14.9
     */
    public function generateRssFeed(?string $language = 'en', int $limit = 20): string
    {
        $news = $this->getPublishedNews(null, $language, $limit);
        
        $rss = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $rss .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $rss .= '<channel>' . "\n";
        $rss .= '<title>' . $this->escapeXml(config('app.name') . ' - News') . '</title>' . "\n";
        $rss .= '<link>' . $this->escapeXml(config('app.url')) . '</link>' . "\n";
        $rss .= '<description>' . $this->escapeXml('Latest news from ' . config('app.name')) . '</description>' . "\n";
        $rss .= '<language>' . $language . '</language>' . "\n";
        $rss .= '<lastBuildDate>' . now()->toRssString() . '</lastBuildDate>' . "\n";
        $rss .= '<atom:link href="' . $this->escapeXml(route('news.rss')) . '" rel="self" type="application/rss+xml" />' . "\n";
        
        foreach ($news as $article) {
            $rss .= '<item>' . "\n";
            $rss .= '<title>' . $this->escapeXml($article->title) . '</title>' . "\n";
            $rss .= '<link>' . $this->escapeXml(route('news.show', $article->slug)) . '</link>' . "\n";
            $rss .= '<guid isPermaLink="true">' . $this->escapeXml(route('news.show', $article->slug)) . '</guid>' . "\n";
            $rss .= '<description>' . $this->escapeXml($article->excerpt) . '</description>' . "\n";
            $rss .= '<pubDate>' . $article->published_at->toRssString() . '</pubDate>' . "\n";
            
            if ($article->author) {
                $rss .= '<author>' . $this->escapeXml($article->author->email . ' (' . $article->author->name . ')') . '</author>' . "\n";
            }
            
            if ($article->category) {
                $rss .= '<category>' . $this->escapeXml(ucfirst($article->category)) . '</category>' . "\n";
            }
            
            if ($article->featuredImage) {
                $imageUrl = asset('storage/' . $article->featuredImage->path);
                $rss .= '<enclosure url="' . $this->escapeXml($imageUrl) . '" type="' . $this->escapeXml($article->featuredImage->mime_type) . '" length="' . $article->featuredImage->size . '" />' . "\n";
            }
            
            $rss .= '</item>' . "\n";
        }
        
        $rss .= '</channel>' . "\n";
        $rss .= '</rss>';
        
        return $rss;
    }

    /**
     * Escape XML special characters.
     */
    protected function escapeXml(string $text): string
    {
        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
