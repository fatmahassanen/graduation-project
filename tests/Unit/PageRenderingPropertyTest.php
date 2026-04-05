<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRenderingPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected PageService $pageService;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pageService = app(PageService::class);
        $this->user = User::factory()->create(['role' => 'super_admin']);
    }

    /**
     * Feature: university-cms-upgrade, Property 24: Published Content Filtering
     * For any public-facing query (navigation, search, page access), only pages 
     * with status='published' SHALL be included in results.
     * 
     * **Validates: Requirements 9.6, 9.9, 16.8**
     * 
     * Minimum 100 iterations for property-based testing.
     */
    public function test_property_published_content_filtering(): void
    {
        $iterations = 100;
        
        for ($i = 0; $i < $iterations; $i++) {
            $testCase = $this->generateRandomPublishedContentFilteringTestCase();

            // Create pages with different statuses
            $publishedPages = [];
            $nonPublishedPages = [];

            foreach ($testCase['pages'] as $pageData) {
                $page = Page::factory()->create([
                    'slug' => $pageData['slug'],
                    'language' => $pageData['language'],
                    'status' => $pageData['status'],
                    'title' => $pageData['title'],
                    'category' => $pageData['category'],
                ]);

                if ($pageData['status'] === 'published') {
                    $publishedPages[] = $page;
                } else {
                    $nonPublishedPages[] = $page;
                }
            }

            // Test 1: PageService getPublishedPageBySlug should only return published pages
            foreach ($publishedPages as $page) {
                $retrieved = $this->pageService->getPublishedPageBySlug($page->slug, $page->language);
                
                $this->assertNotNull(
                    $retrieved,
                    "Iteration {$i}: Published page '{$page->slug}' should be retrievable via getPublishedPageBySlug"
                );
                $this->assertEquals(
                    $page->id,
                    $retrieved->id,
                    "Iteration {$i}: Retrieved page should match the published page"
                );
            }

            // Test 2: PageService should NOT return draft or archived pages
            foreach ($nonPublishedPages as $page) {
                $retrieved = $this->pageService->getPublishedPageBySlug($page->slug, $page->language);
                
                $this->assertNull(
                    $retrieved,
                    "Iteration {$i}: Non-published page '{$page->slug}' with status '{$page->status}' should NOT be retrievable via getPublishedPageBySlug"
                );
            }

            // Test 3: Eloquent published scope should only return published pages
            $scopedPages = Page::published()->get();
            
            foreach ($scopedPages as $scopedPage) {
                $this->assertEquals(
                    'published',
                    $scopedPage->status,
                    "Iteration {$i}: Published scope should only return pages with status='published'"
                );
            }

            // Test 4: Count of published pages should match expected
            $publishedCount = Page::published()->count();
            $this->assertEquals(
                count($publishedPages),
                $publishedCount,
                "Iteration {$i}: Published scope should return exactly " . count($publishedPages) . " published pages"
            );

            // Test 5: Draft and archived pages should not appear in published scope
            foreach ($nonPublishedPages as $page) {
                $foundInPublished = Page::published()
                    ->where('id', $page->id)
                    ->exists();
                
                $this->assertFalse(
                    $foundInPublished,
                    "Iteration {$i}: Page with status '{$page->status}' should NOT appear in published scope"
                );
            }

            // Clean up for next iteration
            Page::query()->delete();
        }
    }

    /**
     * Generate a random test case for published content filtering property.
     */
    private function generateRandomPublishedContentFilteringTestCase(): array
    {
        $statuses = ['published', 'draft', 'archived'];
        $languages = ['en', 'ar'];
        $categories = ['admissions', 'faculties', 'events', 'about', 'quality', 'media', 'campus', 'staff', 'student_services'];
        
        $numPages = rand(2, 8);
        $pages = [];
        
        for ($i = 0; $i < $numPages; $i++) {
            $pages[] = [
                'slug' => 'page-' . uniqid(),
                'language' => $languages[array_rand($languages)],
                'status' => $statuses[array_rand($statuses)],
                'title' => 'Test Page ' . $i,
                'category' => $categories[array_rand($categories)],
            ];
        }
        
        return ['pages' => $pages];
    }

    /**
     * Generate test cases for published content filtering property.
     * Each test case includes pages with various statuses to verify filtering.
     */
    private function generatePublishedContentFilteringTestCases(): array
    {
        return [
            // Test Case 1: Mix of published, draft, and archived pages
            [
                'pages' => [
                    [
                        'slug' => 'about-us',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'About Us',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'contact',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Contact Us',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'draft-page',
                        'language' => 'en',
                        'status' => 'draft',
                        'title' => 'Draft Page',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'archived-page',
                        'language' => 'en',
                        'status' => 'archived',
                        'title' => 'Archived Page',
                        'category' => 'about',
                    ],
                ],
            ],
            // Test Case 2: Multiple languages with different statuses
            [
                'pages' => [
                    [
                        'slug' => 'admissions',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Admissions',
                        'category' => 'admissions',
                    ],
                    [
                        'slug' => 'admissions',
                        'language' => 'ar',
                        'status' => 'draft',
                        'title' => 'القبول',
                        'category' => 'admissions',
                    ],
                    [
                        'slug' => 'events',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Events',
                        'category' => 'events',
                    ],
                    [
                        'slug' => 'events',
                        'language' => 'ar',
                        'status' => 'published',
                        'title' => 'الفعاليات',
                        'category' => 'events',
                    ],
                ],
            ],
            // Test Case 3: All pages in different categories
            [
                'pages' => [
                    [
                        'slug' => 'faculty-it',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Faculty of IT',
                        'category' => 'faculties',
                    ],
                    [
                        'slug' => 'campus-tour',
                        'language' => 'en',
                        'status' => 'draft',
                        'title' => 'Campus Tour',
                        'category' => 'campus',
                    ],
                    [
                        'slug' => 'quality-assurance',
                        'language' => 'en',
                        'status' => 'archived',
                        'title' => 'Quality Assurance',
                        'category' => 'quality',
                    ],
                    [
                        'slug' => 'media-center',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Media Center',
                        'category' => 'media',
                    ],
                ],
            ],
            // Test Case 4: Only published pages
            [
                'pages' => [
                    [
                        'slug' => 'page-1',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Page 1',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'page-2',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Page 2',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'page-3',
                        'language' => 'en',
                        'status' => 'published',
                        'title' => 'Page 3',
                        'category' => 'about',
                    ],
                ],
            ],
            // Test Case 5: Only draft and archived pages (no published)
            [
                'pages' => [
                    [
                        'slug' => 'draft-1',
                        'language' => 'en',
                        'status' => 'draft',
                        'title' => 'Draft 1',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'draft-2',
                        'language' => 'en',
                        'status' => 'draft',
                        'title' => 'Draft 2',
                        'category' => 'about',
                    ],
                    [
                        'slug' => 'archived-1',
                        'language' => 'en',
                        'status' => 'archived',
                        'title' => 'Archived 1',
                        'category' => 'about',
                    ],
                ],
            ],
        ];
    }
}
