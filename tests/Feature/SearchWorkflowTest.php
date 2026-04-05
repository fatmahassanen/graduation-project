<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\News;
use App\Models\Page;
use App\Models\User;
use App\Services\SearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SearchWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected SearchService $searchService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'content_editor']);
        $this->searchService = app(SearchService::class);
    }

    public function test_search_workflow_across_multiple_content_types(): void
    {
        // Create published content across different types
        $page = Page::factory()->create([
            'title' => 'Computer Science Department',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Learn about our computer science programs',
            'created_by' => $this->user->id,
        ]);

        $news = News::factory()->create([
            'title' => 'New Computer Lab Opening',
            'excerpt' => 'State-of-the-art computer facilities',
            'body' => 'Our new computer lab features the latest technology',
            'status' => 'published',
            'language' => 'en',
            'author_id' => $this->user->id,
            'published_at' => now(),
        ]);

        $event = Event::factory()->create([
            'title' => 'Computer Science Workshop',
            'description' => 'Learn programming fundamentals',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        // Search for "computer"
        $results = $this->searchService->search('computer');

        // Verify results include all content types
        $this->assertGreaterThanOrEqual(3, $results->count());

        $types = $results->pluck('type')->unique();
        $this->assertContains('page', $types);
        $this->assertContains('news', $types);
        $this->assertContains('event', $types);
    }

    public function test_search_workflow_with_filtering(): void
    {
        // Create content in different categories
        Page::factory()->create([
            'title' => 'Admissions Information',
            'category' => 'admissions',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        Page::factory()->create([
            'title' => 'Faculty Information',
            'category' => 'faculties',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        News::factory()->create([
            'title' => 'Information Session',
            'excerpt' => 'Join us for an information session',
            'body' => 'Learn more about our programs',
            'category' => 'announcement',
            'status' => 'published',
            'language' => 'en',
            'author_id' => $this->user->id,
            'published_at' => now(),
        ]);

        // Search with content type filter
        $results = $this->searchService->search('information', ['content_type' => 'pages']);

        // Verify only pages are returned
        $this->assertGreaterThan(0, $results->count());
        $types = $results->pluck('type')->unique();
        $this->assertCount(1, $types);
        $this->assertEquals('page', $types->first());
    }

    public function test_search_workflow_with_relevance_ordering(): void
    {
        // Create pages with different relevance scores
        $exactMatch = Page::factory()->create([
            'title' => 'Engineering',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Engineering department',
            'created_by' => $this->user->id,
        ]);

        $titleMatch = Page::factory()->create([
            'title' => 'Engineering Programs',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Various programs available',
            'created_by' => $this->user->id,
        ]);

        $contentMatch = Page::factory()->create([
            'title' => 'Academic Departments',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Including engineering and other fields',
            'created_by' => $this->user->id,
        ]);

        // Search for "engineering"
        $results = $this->searchService->search('engineering');

        // Verify results are ordered by relevance
        $this->assertGreaterThanOrEqual(3, $results->count());

        // Exact match should have highest score
        $firstResult = $results->first();
        $this->assertEquals('Engineering', $firstResult['title']);
        $this->assertGreaterThan(0, $firstResult['relevance_score']);

        // Verify scores are in descending order
        $scores = $results->pluck('relevance_score');
        $sortedScores = $scores->sortDesc()->values();
        $this->assertEquals($sortedScores->toArray(), $scores->toArray());
    }

    public function test_search_workflow_logs_queries(): void
    {
        // Create some published content
        Page::factory()->create([
            'title' => 'Test Page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        // Perform a search
        $results = $this->searchService->search('test query');

        // Verify search was logged
        $this->assertDatabaseHas('search_logs', [
            'query' => 'test query',
        ]);

        // Verify log contains results count
        $log = DB::table('search_logs')
            ->where('query', 'test query')
            ->first();

        $this->assertNotNull($log);
        $this->assertIsInt($log->results_count);
        $this->assertNotNull($log->ip_address);
    }

    public function test_search_workflow_only_returns_published_content(): void
    {
        // Create published and draft pages
        $publishedPage = Page::factory()->create([
            'title' => 'Published Research',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        $draftPage = Page::factory()->create([
            'title' => 'Draft Research',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        $archivedPage = Page::factory()->create([
            'title' => 'Archived Research',
            'status' => 'archived',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        // Search for "research"
        $results = $this->searchService->search('research');

        // Verify only published content is returned
        $titles = $results->pluck('title');
        $this->assertContains('Published Research', $titles);
        $this->assertNotContains('Draft Research', $titles);
        $this->assertNotContains('Archived Research', $titles);
    }

    public function test_search_workflow_with_language_filter(): void
    {
        // Create pages in different languages
        $englishPage = Page::factory()->create([
            'title' => 'English Page',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'This is an English page',
            'created_by' => $this->user->id,
        ]);

        $arabicPage = Page::factory()->create([
            'title' => 'Arabic Page',
            'status' => 'published',
            'language' => 'ar',
            'meta_description' => 'This is an Arabic page',
            'created_by' => $this->user->id,
        ]);

        // Search with English language filter
        $results = $this->searchService->search('page', ['language' => 'en']);

        // Verify only English content is returned
        $this->assertGreaterThan(0, $results->count());
        $titles = $results->pluck('title');
        $this->assertContains('English Page', $titles);
        $this->assertNotContains('Arabic Page', $titles);
    }

    public function test_complete_search_workflow(): void
    {
        // Step 1: Create diverse published content
        $page1 = Page::factory()->create([
            'title' => 'University Admissions',
            'category' => 'admissions',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Apply to our university programs',
            'created_by' => $this->user->id,
        ]);

        $page2 = Page::factory()->create([
            'title' => 'Faculty of Engineering',
            'category' => 'faculties',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Engineering programs and research',
            'created_by' => $this->user->id,
        ]);

        $news1 = News::factory()->create([
            'title' => 'New Engineering Building',
            'excerpt' => 'State-of-the-art facilities',
            'body' => 'Our new engineering building opens next month',
            'category' => 'announcement',
            'status' => 'published',
            'language' => 'en',
            'author_id' => $this->user->id,
            'published_at' => now(),
        ]);

        $event1 = Event::factory()->create([
            'title' => 'Engineering Open Day',
            'description' => 'Visit our engineering facilities',
            'category' => 'conference',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        // Create draft content (should not appear in results)
        $draftPage = Page::factory()->create([
            'title' => 'Draft Engineering Page',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $this->user->id,
        ]);

        // Step 2: Perform search
        $results = $this->searchService->search('engineering');

        // Step 3: Verify results
        $this->assertGreaterThanOrEqual(3, $results->count());

        // Verify multiple content types
        $types = $results->pluck('type')->unique();
        $this->assertGreaterThan(1, $types->count());

        // Verify relevance ordering
        $scores = $results->pluck('relevance_score');
        $this->assertTrue($scores->first() >= $scores->last());

        // Verify only published content
        $titles = $results->pluck('title');
        $this->assertNotContains('Draft Engineering Page', $titles);

        // Step 4: Verify search was logged
        $this->assertDatabaseHas('search_logs', [
            'query' => 'engineering',
        ]);

        $log = DB::table('search_logs')
            ->where('query', 'engineering')
            ->first();

        $this->assertNotNull($log);
        $this->assertEquals($results->count(), $log->results_count);

        // Step 5: Test filtered search
        $filteredResults = $this->searchService->search('engineering', ['content_type' => 'pages']);

        // Verify filtering works
        $filteredTypes = $filteredResults->pluck('type')->unique();
        $this->assertCount(1, $filteredTypes);
        $this->assertEquals('page', $filteredTypes->first());
    }

    public function test_search_workflow_handles_special_characters(): void
    {
        // Create page with special characters
        Page::factory()->create([
            'title' => 'C++ Programming',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Learn C++ programming',
            'created_by' => $this->user->id,
        ]);

        // Search should handle special characters safely
        $results = $this->searchService->search('C++');

        // Verify results are returned without errors
        $this->assertGreaterThan(0, $results->count());
        $titles = $results->pluck('title');
        $this->assertContains('C++ Programming', $titles);
    }
}
