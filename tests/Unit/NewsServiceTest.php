<?php

namespace Tests\Unit;

use App\Models\News;
use App\Models\User;
use App\Services\NewsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected NewsService $newsService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->newsService = app(NewsService::class);
    }

    public function test_get_published_news_returns_only_published_articles(): void
    {
        $user = User::factory()->create();

        // Create draft news
        News::factory()->create([
            'status' => 'draft',
            'author_id' => $user->id,
        ]);

        // Create published news
        $publishedNews = News::factory()->create([
            'status' => 'published',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $news = $this->newsService->getPublishedNews();

        $this->assertCount(1, $news);
        $this->assertEquals($publishedNews->id, $news->first()->id);
    }

    public function test_get_published_news_filters_by_category(): void
    {
        $user = User::factory()->create();

        News::factory()->create([
            'status' => 'published',
            'category' => 'announcement',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        News::factory()->create([
            'status' => 'published',
            'category' => 'research',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $news = $this->newsService->getPublishedNews('announcement');

        $this->assertCount(1, $news);
        $this->assertEquals('announcement', $news->first()->category);
    }

    public function test_get_related_news_returns_same_category(): void
    {
        $user = User::factory()->create();

        $mainNews = News::factory()->create([
            'status' => 'published',
            'category' => 'research',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $relatedNews = News::factory()->create([
            'status' => 'published',
            'category' => 'research',
            'published_at' => now()->subDay(),
            'author_id' => $user->id,
        ]);

        News::factory()->create([
            'status' => 'published',
            'category' => 'announcement',
            'published_at' => now()->subDays(2),
            'author_id' => $user->id,
        ]);

        $related = $this->newsService->getRelatedNews($mainNews);

        $this->assertCount(1, $related);
        $this->assertEquals($relatedNews->id, $related->first()->id);
    }

    public function test_get_related_news_excludes_current_article(): void
    {
        $user = User::factory()->create();

        $mainNews = News::factory()->create([
            'status' => 'published',
            'category' => 'research',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $related = $this->newsService->getRelatedNews($mainNews);

        $this->assertFalse($related->contains('id', $mainNews->id));
    }

    public function test_get_featured_news_returns_only_featured(): void
    {
        $user = User::factory()->create();

        News::factory()->create([
            'status' => 'published',
            'is_featured' => false,
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $featuredNews = News::factory()->create([
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $featured = $this->newsService->getFeaturedNews();

        $this->assertCount(1, $featured);
        $this->assertEquals($featuredNews->id, $featured->first()->id);
    }

    public function test_generate_rss_feed_creates_valid_xml(): void
    {
        $user = User::factory()->create();

        News::factory()->create([
            'status' => 'published',
            'title' => 'Test News',
            'excerpt' => 'Test Excerpt',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $rss = $this->newsService->generateRssFeed();

        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $rss);
        $this->assertStringContainsString('<rss version="2.0"', $rss);
        $this->assertStringContainsString('<channel>', $rss);
        $this->assertStringContainsString('<title>Test News</title>', $rss);
        $this->assertStringContainsString('<description>Test Excerpt</description>', $rss);
        $this->assertStringContainsString('</channel>', $rss);
        $this->assertStringContainsString('</rss>', $rss);
    }

    public function test_get_published_news_orders_by_published_at_desc(): void
    {
        $user = User::factory()->create();

        $news1 = News::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'author_id' => $user->id,
        ]);

        $news2 = News::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
            'author_id' => $user->id,
        ]);

        $news = $this->newsService->getPublishedNews();

        $this->assertEquals($news2->id, $news->first()->id);
        $this->assertEquals($news1->id, $news->last()->id);
    }

    public function test_get_published_news_respects_limit(): void
    {
        $user = User::factory()->create();

        News::factory()->count(5)->create([
            'status' => 'published',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        $news = $this->newsService->getPublishedNews(null, 'en', 3);

        $this->assertCount(3, $news);
    }

    public function test_get_related_news_respects_limit(): void
    {
        $user = User::factory()->create();

        $mainNews = News::factory()->create([
            'status' => 'published',
            'category' => 'research',
            'published_at' => now(),
            'author_id' => $user->id,
        ]);

        News::factory()->count(10)->create([
            'status' => 'published',
            'category' => 'research',
            'published_at' => now()->subDay(),
            'author_id' => $user->id,
        ]);

        $related = $this->newsService->getRelatedNews($mainNews, 3);

        $this->assertCount(3, $related);
    }
}
