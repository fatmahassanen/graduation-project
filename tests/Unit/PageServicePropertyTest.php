<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Services\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageServicePropertyTest extends TestCase
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
     * Feature: university-cms-upgrade, Property 1: Slug Generation Validity
     * For any page title string, the generated slug SHALL be URL-safe 
     * (lowercase alphanumeric with hyphens) and derived from the title content.
     * 
     * **Validates: Requirements 1.3**
     */
    public function test_property_slug_generation_validity(): void
    {
        $testCases = $this->generateSlugTestCases();

        foreach ($testCases as $testCase) {
            $slug = $this->pageService->generateUniqueSlug($testCase['title']);

            // Assert slug is URL-safe: lowercase alphanumeric with hyphens
            $this->assertMatchesRegularExpression(
                '/^[a-z0-9]+(-[a-z0-9]+)*$/',
                $slug,
                "Slug '{$slug}' generated from '{$testCase['title']}' is not URL-safe"
            );

            // Assert slug is derived from title (contains some recognizable part)
            // We check that the slug is not empty and is related to the title
            $this->assertNotEmpty($slug, "Slug should not be empty for title '{$testCase['title']}'");
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 2: Slug Uniqueness with Suffixes
     * For any set of pages with the same base slug and language, all final slugs 
     * SHALL be unique with numeric suffixes appended as needed.
     * 
     * **Validates: Requirements 1.4**
     */
    public function test_property_slug_uniqueness_with_suffixes(): void
    {
        $testCases = $this->generateSlugUniquenessTestCases();

        foreach ($testCases as $testCase) {
            // Create pages with the same base title
            $generatedSlugs = [];
            
            for ($i = 0; $i < $testCase['count']; $i++) {
                $slug = $this->pageService->generateUniqueSlug($testCase['baseTitle']);
                
                // Create the page to make the slug exist in database
                Page::factory()->create([
                    'title' => $testCase['baseTitle'] . " {$i}",
                    'slug' => $slug,
                    'language' => $testCase['language'],
                ]);
                
                $generatedSlugs[] = $slug;
            }

            // Assert all slugs are unique
            $uniqueSlugs = array_unique($generatedSlugs);
            $this->assertCount(
                count($generatedSlugs),
                $uniqueSlugs,
                "Generated slugs are not unique: " . implode(', ', $generatedSlugs)
            );

            // Assert numeric suffixes are appended correctly
            if (count($generatedSlugs) > 1) {
                // First slug should be the base
                $this->assertEquals($testCase['expectedBase'], $generatedSlugs[0]);
                
                // Subsequent slugs should have numeric suffixes
                for ($i = 1; $i < count($generatedSlugs); $i++) {
                    $this->assertEquals(
                        $testCase['expectedBase'] . '-' . $i,
                        $generatedSlugs[$i],
                        "Slug at position {$i} should have suffix -{$i}"
                    );
                }
            }
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 4: Page Serialization Round-Trip
     * For any valid Page object, serializing to array then deserializing SHALL 
     * produce an equivalent Page object with identical field values.
     * 
     * **Validates: Requirements 1.9**
     */
    public function test_property_page_serialization_round_trip(): void
    {
        $testCases = $this->generatePageSerializationTestCases();

        foreach ($testCases as $testCase) {
            // Create a page with specific attributes
            $originalPage = Page::factory()->create($testCase['attributes']);

            // Serialize to array
            $serialized = $originalPage->toArray();

            // Create a new page from the serialized data
            $deserializedPage = new Page();
            $deserializedPage->fill($serialized);
            $deserializedPage->id = $serialized['id'];
            $deserializedPage->exists = true;

            // Assert key fields are identical
            $fieldsToCheck = [
                'title', 'slug', 'category', 'status', 'language',
                'meta_title', 'meta_description', 'meta_keywords', 'og_image'
            ];

            foreach ($fieldsToCheck as $field) {
                $this->assertEquals(
                    $originalPage->$field,
                    $deserializedPage->$field,
                    "Field '{$field}' does not match after round-trip serialization"
                );
            }
        }
    }

    /**
     * Feature: university-cms-upgrade, Property 12: Slug-Language Uniqueness
     * For any set of pages, the combination of slug and language SHALL be unique, 
     * allowing same slug across different languages.
     * 
     * **Validates: Requirements 4.3**
     */
    public function test_property_slug_language_uniqueness(): void
    {
        $testCases = $this->generateSlugLanguageUniquenessTestCases();

        foreach ($testCases as $testCase) {
            $createdPages = [];

            // Create pages with same slug but different languages
            foreach ($testCase['languages'] as $language) {
                $page = Page::factory()->create([
                    'slug' => $testCase['slug'],
                    'language' => $language,
                    'title' => $testCase['title'] . " ({$language})",
                ]);
                $createdPages[] = $page;
            }

            // Assert all pages were created successfully
            $this->assertCount(
                count($testCase['languages']),
                $createdPages,
                "Should be able to create pages with same slug in different languages"
            );

            // Assert each slug-language combination is unique in database
            foreach ($createdPages as $page) {
                $duplicates = Page::where('slug', $page->slug)
                    ->where('language', $page->language)
                    ->count();

                $this->assertEquals(
                    1,
                    $duplicates,
                    "Slug '{$page->slug}' with language '{$page->language}' should be unique"
                );
            }

            // Assert we can retrieve each page by slug and language
            foreach ($createdPages as $page) {
                $retrieved = Page::where('slug', $page->slug)
                    ->where('language', $page->language)
                    ->first();

                $this->assertNotNull($retrieved);
                $this->assertEquals($page->id, $retrieved->id);
            }
        }
    }

    /**
     * Generate test cases for slug generation validity property.
     * Returns various title strings to test URL-safe slug generation.
     */
    private function generateSlugTestCases(): array
    {
        return [
            ['title' => 'About University'],
            ['title' => 'Faculty of Engineering'],
            ['title' => 'Student Services & Support'],
            ['title' => 'Events Calendar 2024'],
            ['title' => 'Contact Us!'],
            ['title' => 'Admissions - Apply Now'],
            ['title' => 'Research & Development'],
            ['title' => 'Campus Life @ University'],
            ['title' => 'Quality Assurance'],
            ['title' => 'Media Center'],
            ['title' => 'Staff Directory'],
            ['title' => 'About Us (English)'],
            ['title' => 'FAQ - Frequently Asked Questions'],
            ['title' => 'News & Updates'],
            ['title' => 'Academic Programs'],
            ['title' => 'International Students'],
            ['title' => 'Alumni Network'],
            ['title' => 'Library Resources'],
            ['title' => 'IT Services'],
            ['title' => 'Health & Safety'],
        ];
    }

    /**
     * Generate test cases for slug uniqueness with suffixes property.
     */
    private function generateSlugUniquenessTestCases(): array
    {
        return [
            [
                'baseTitle' => 'About University',
                'expectedBase' => 'about-university',
                'count' => 3,
                'language' => 'en',
            ],
            [
                'baseTitle' => 'Faculty Page',
                'expectedBase' => 'faculty-page',
                'count' => 5,
                'language' => 'en',
            ],
            [
                'baseTitle' => 'Events',
                'expectedBase' => 'events',
                'count' => 4,
                'language' => 'ar',
            ],
            [
                'baseTitle' => 'Contact',
                'expectedBase' => 'contact',
                'count' => 2,
                'language' => 'en',
            ],
        ];
    }

    /**
     * Generate test cases for page serialization round-trip property.
     */
    private function generatePageSerializationTestCases(): array
    {
        return [
            [
                'attributes' => [
                    'title' => 'About University',
                    'slug' => 'about-university',
                    'category' => 'about',
                    'status' => 'published',
                    'language' => 'en',
                    'meta_title' => 'About Us - University',
                    'meta_description' => 'Learn about our university',
                    'meta_keywords' => 'university, about, education',
                    'og_image' => 'https://example.com/image.jpg',
                ],
            ],
            [
                'attributes' => [
                    'title' => 'Admissions',
                    'slug' => 'admissions',
                    'category' => 'admissions',
                    'status' => 'draft',
                    'language' => 'ar',
                    'meta_title' => null,
                    'meta_description' => null,
                    'meta_keywords' => null,
                    'og_image' => null,
                ],
            ],
            [
                'attributes' => [
                    'title' => 'Faculty of Engineering',
                    'slug' => 'faculty-engineering',
                    'category' => 'faculties',
                    'status' => 'published',
                    'language' => 'en',
                    'meta_title' => 'Engineering Faculty',
                    'meta_description' => 'Top engineering programs',
                    'meta_keywords' => 'engineering, faculty, programs',
                    'og_image' => 'https://example.com/engineering.jpg',
                ],
            ],
            [
                'attributes' => [
                    'title' => 'Campus Life',
                    'slug' => 'campus-life',
                    'category' => 'campus',
                    'status' => 'archived',
                    'language' => 'en',
                    'meta_title' => 'Campus Life',
                    'meta_description' => 'Experience campus life',
                    'meta_keywords' => 'campus, life, students',
                    'og_image' => null,
                ],
            ],
            [
                'attributes' => [
                    'title' => 'Events Calendar',
                    'slug' => 'events-calendar',
                    'category' => 'events',
                    'status' => 'published',
                    'language' => 'en',
                    'meta_title' => 'University Events',
                    'meta_description' => 'Upcoming university events',
                    'meta_keywords' => 'events, calendar, activities',
                    'og_image' => 'https://example.com/events.jpg',
                ],
            ],
        ];
    }

    /**
     * Generate test cases for slug-language uniqueness property.
     */
    private function generateSlugLanguageUniquenessTestCases(): array
    {
        return [
            [
                'slug' => 'about-university',
                'title' => 'About University',
                'languages' => ['en', 'ar'],
            ],
            [
                'slug' => 'admissions',
                'title' => 'Admissions',
                'languages' => ['en', 'ar'],
            ],
            [
                'slug' => 'faculty-engineering',
                'title' => 'Faculty of Engineering',
                'languages' => ['en', 'ar'],
            ],
            [
                'slug' => 'events',
                'title' => 'Events',
                'languages' => ['en', 'ar'],
            ],
            [
                'slug' => 'contact-us',
                'title' => 'Contact Us',
                'languages' => ['en', 'ar'],
            ],
        ];
    }
}
