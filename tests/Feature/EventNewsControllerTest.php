<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventNewsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_page_loads_successfully(): void
    {
        $response = $this->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('events.index');
        $response->assertViewHas(['upcomingEvents', 'pastEvents', 'categories']);
    }

    public function test_news_index_page_loads_successfully(): void
    {
        $response = $this->get(route('news.index'));

        $response->assertStatus(200);
        $response->assertViewIs('news.index');
        $response->assertViewHas(['news', 'featuredNews', 'categories']);
    }

    public function test_published_event_can_be_viewed(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => 'published',
            'created_by' => $user->id,
        ]);

        $response = $this->get(route('events.show', $event->id));

        $response->assertStatus(200);
        $response->assertViewIs('events.show');
        $response->assertSee($event->title);
    }

    public function test_published_news_can_be_viewed(): void
    {
        $user = User::factory()->create();
        $news = News::factory()->create([
            'status' => 'published',
            'author_id' => $user->id,
            'published_at' => now(),
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(200);
        $response->assertViewIs('news.show');
        $response->assertSee($news->title);
    }

    public function test_draft_event_returns_404(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        $response = $this->get(route('events.show', $event->id));

        $response->assertStatus(404);
    }

    public function test_draft_news_returns_404(): void
    {
        $user = User::factory()->create();
        $news = News::factory()->create([
            'status' => 'draft',
            'author_id' => $user->id,
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(404);
    }

    public function test_event_ical_export_works(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => 'published',
            'created_by' => $user->id,
        ]);

        $response = $this->get(route('events.export', $event->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/calendar; charset=utf-8');
        $response->assertSee('BEGIN:VCALENDAR');
        $response->assertSee('BEGIN:VEVENT');
    }

    public function test_event_ical_export_strips_html_tags(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'status' => 'published',
            'created_by' => $user->id,
            'description' => '<p>This is a <strong>test</strong> event with <a href="#">HTML</a> tags.</p>',
        ]);

        $response = $this->get(route('events.export', $event->id));

        $response->assertStatus(200);
        $response->assertDontSee('<p>');
        $response->assertDontSee('<strong>');
        $response->assertDontSee('<a href="#">');
        $response->assertSee('This is a test event with HTML tags.');
    }

    public function test_news_rss_feed_works(): void
    {
        $response = $this->get(route('news.rss'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/rss+xml; charset=utf-8');
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $response->getContent());
        $this->assertStringContainsString('<rss version="2.0"', $response->getContent());
    }

    public function test_events_can_be_filtered_by_category(): void
    {
        $user = User::factory()->create();
        
        Event::factory()->create([
            'status' => 'published',
            'category' => 'conference',
            'created_by' => $user->id,
        ]);
        
        Event::factory()->create([
            'status' => 'published',
            'category' => 'workshop',
            'created_by' => $user->id,
        ]);

        $response = $this->get(route('events.index', ['category' => 'conference']));

        $response->assertStatus(200);
    }

    public function test_news_can_be_filtered_by_category(): void
    {
        $user = User::factory()->create();
        
        News::factory()->create([
            'status' => 'published',
            'category' => 'announcement',
            'author_id' => $user->id,
            'published_at' => now(),
        ]);
        
        News::factory()->create([
            'status' => 'published',
            'category' => 'research',
            'author_id' => $user->id,
            'published_at' => now(),
        ]);

        $response = $this->get(route('news.index', ['category' => 'announcement']));

        $response->assertStatus(200);
    }
}
