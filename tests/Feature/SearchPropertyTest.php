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

class SearchPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SearchService $searchService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->searchService = new SearchService();
    }

    /**
     * Property 30: Search Query Matching and Filtering
     * 
     * For any search query and filters, results SHALL only include content 
     * that matches the query AND satisfies all filter criteria (category, language, content type).
     * 
     * Validates: Requirements 16.2, 16.6, 16.8
     */
    public function test_property_30_search_query_matching_and_filtering(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create test data with different languages and categories
        $englishPage = Page::factory()->create([
            'title' => 'Laravel Framework Guide',
            'slug' => 'laravel-guide',
            'status' => 'published',
            'language' => 'en',
            'category' => 'admissions',
            'meta_description' => 'Complete guide to Laravel framework',
            'created_by' => $user->id,
        ]);

        $arabicPage = Page::factory()->create([
            'title' => 'دليل Laravel',
            'slug' => 'laravel-guide-ar',
            'status' => 'published',
            'language' => 'ar',
            'category' => 'admissions',
            'meta_description' => 'دليل كامل لإطار Laravel',
            'created_by' => $user->id,
        ]);

        $draftPage = Page::factory()->create([
            'title' => 'Laravel Advanced Topics',
            'slug' => 'laravel-advanced',
            'status' => 'draft',
            'language' => 'en',
            'category' => 'admissions',
            'created_by' => $user->id,
        ]);

        // Test 1: Search without filters returns only published content
        $results = $this->searchService->search('Laravel', []);
        $this->assertGreaterThan(0, $results->count());
        
        // Verify draft page is not in results
        $resultIds = $results->pluck('id')->toArray();
        $this->assertNotContains($draftPage->id, $resultIds);

        // Test 2: Language filter works correctly
        $englishResults = $this->searchService->search('Laravel', ['language' => 'en']);
        $this->assertGreaterThan(0, $englishResults->count());
        foreach ($englishResults as $result) {
            if ($result['type'] === 'page') {
                $page = Page::find($result['id']);
                $this->assertEquals('en', $page->language);
            }
        }

        // Test 3: Content type filter works correctly
        $pageResults = $this->searchService->search('Laravel', ['content_type' => 'pages']);
        foreach ($pageResults as $result) {
            $this->assertEquals('page', $result['type']);
        }

        // Test 4: Category filter works correctly
        $categoryResults = $this->searchService->search('Laravel', ['category' => 'admissions']);
        $this->assertGreaterThan(0, $categoryResults->count());
    }

    /**
     * Property 31: Search Results Relevance Ordering
     * 
     * For any search query, results SHALL be ordered by relevance score in descending order,
     * with exact title matches ranked higher than partial matches.
     * 
     * Validates: Requirements 16.5
     */
    public function test_property_31_search_results_relevance_ordering(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create pages with different relevance levels
        $exactMatch = Page::factory()->create([
            'title' => 'Laravel',
            'slug' => 'laravel',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Laravel framework',
            'created_by' => $user->id,
        ]);

        $titleMatch = Page::factory()->create([
            'title' => 'Laravel Framework Guide',
            'slug' => 'laravel-guide',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Complete guide',
            'created_by' => $user->id,
        ]);

        $contentMatch = Page::factory()->create([
            'title' => 'PHP Frameworks',
            'slug' => 'php-frameworks',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Laravel is a popular PHP framework',
            'created_by' => $user->id,
        ]);

        // Search for "Laravel"
        $results = $this->searchService->search('Laravel', ['language' => 'en']);

        // Verify results are ordered by relevance
        $this->assertGreaterThanOrEqual(3, $results->count());

        // Extract relevance scores
        $scores = $results->pluck('relevance_score')->toArray();

        // Verify scores are in descending order
        $sortedScores = $scores;
        rsort($sortedScores);
        $this->assertEquals($sortedScores, $scores, 'Results should be ordered by relevance score descending');

        // Verify exact match has highest score
        $firstResult = $results->first();
        $this->assertEquals($exactMatch->id, $firstResult['id']);
    }

    /**
     * Property 32: Search Query Logging
     * 
     * For any search query executed, a log entry SHALL be created in search_logs table
     * with query, results count, filters, IP address, and timestamp.
     * 
     * Validates: Requirements 16.9
     */
    public function test_property_32_search_query_logging(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create test page
        Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Clear existing search logs
        DB::table('search_logs')->truncate();

        // Perform search
        $query = 'Test';
        $filters = ['language' => 'en', 'category' => 'admissions'];
        $results = $this->searchService->search($query, $filters);

        // Verify log entry was created
        $logEntry = DB::table('search_logs')->latest('created_at')->first();

        $this->assertNotNull($logEntry, 'Search log entry should be created');
        $this->assertEquals($query, $logEntry->query);
        $this->assertEquals($results->count(), $logEntry->results_count);
        $this->assertNotNull($logEntry->ip_address);
        $this->assertNotNull($logEntry->created_at);

        // Verify filters are stored as JSON
        $storedFilters = json_decode($logEntry->filters, true);
        $this->assertEquals($filters['language'], $storedFilters['language']);
        $this->assertEquals($filters['category'], $storedFilters['category']);
    }

    /**
     * Property 30 Extended: Search highlights terms in results
     */
    public function test_property_30_search_highlights_terms(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create test page
        Page::factory()->create([
            'title' => 'Laravel Framework',
            'slug' => 'laravel-framework',
            'status' => 'published',
            'language' => 'en',
            'meta_description' => 'Laravel is a web application framework',
            'created_by' => $user->id,
        ]);

        // Search for "Laravel"
        $results = $this->searchService->search('Laravel', ['language' => 'en']);

        $this->assertGreaterThan(0, $results->count());

        // Verify highlighting in first result
        $firstResult = $results->first();
        $this->assertStringContainsString('<mark class="search-highlight">', $firstResult['highlighted_title']);
        $this->assertStringContainsString('</mark>', $firstResult['highlighted_title']);
    }

    /**
     * Property 30 Extended: Search across multiple content types
     */
    public function test_property_30_search_across_content_types(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        // Create page
        $page = Page::factory()->create([
            'title' => 'University Technology',
            'slug' => 'university-tech',
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Create news
        $news = News::factory()->create([
            'title' => 'Technology Innovation',
            'slug' => 'tech-innovation',
            'excerpt' => 'New technology developments',
            'body' => 'Technology is advancing rapidly',
            'status' => 'published',
            'language' => 'en',
            'author_id' => $user->id,
        ]);

        // Create event
        $event = Event::factory()->create([
            'title' => 'Technology Conference',
            'description' => 'Annual technology conference',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(8),
            'status' => 'published',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Search for "Technology"
        $results = $this->searchService->search('Technology', ['language' => 'en']);

        // Verify results include all content types
        $types = $results->pluck('type')->unique()->toArray();
        $this->assertContains('page', $types);
        $this->assertContains('news', $types);
        $this->assertContains('event', $types);
    }
}
