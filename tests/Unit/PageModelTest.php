<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Models\ContentBlock;
use App\Models\Revision;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_has_fillable_attributes(): void
    {
        $fillable = [
            'title',
            'slug',
            'category',
            'status',
            'language',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'og_image',
            'published_at',
            'created_by',
            'updated_by',
        ];

        $page = new Page();
        $this->assertEquals($fillable, $page->getFillable());
    }

    public function test_published_at_is_cast_to_datetime(): void
    {
        $page = new Page();
        $casts = $page->getCasts();
        
        $this->assertArrayHasKey('published_at', $casts);
        $this->assertEquals('datetime', $casts['published_at']);
    }

    public function test_page_has_content_blocks_relationship(): void
    {
        $page = new Page();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $page->contentBlocks());
    }

    public function test_page_has_creator_relationship(): void
    {
        $page = new Page();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $page->creator());
    }

    public function test_page_has_updater_relationship(): void
    {
        $page = new Page();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $page->updater());
    }

    public function test_page_has_revisions_relationship(): void
    {
        $page = new Page();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class, $page->revisions());
    }

    public function test_published_scope_filters_published_pages(): void
    {
        $user = User::factory()->create();

        $publishedPage = new Page([
            'title' => 'Published Page',
            'slug' => 'published-page',
            'category' => 'about',
            'status' => 'published',
            'language' => 'en',
        ]);
        $publishedPage->created_by = $user->id;
        $publishedPage->save();

        $draftPage = new Page([
            'title' => 'Draft Page',
            'slug' => 'draft-page',
            'category' => 'about',
            'status' => 'draft',
            'language' => 'en',
        ]);
        $draftPage->created_by = $user->id;
        $draftPage->save();

        $publishedPages = Page::published()->get();
        
        $this->assertCount(1, $publishedPages);
        $this->assertEquals('published', $publishedPages->first()->status);
    }

    public function test_by_language_scope_filters_pages_by_language(): void
    {
        $user = User::factory()->create();

        $englishPage = new Page([
            'title' => 'English Page',
            'slug' => 'english-page',
            'category' => 'about',
            'status' => 'published',
            'language' => 'en',
        ]);
        $englishPage->created_by = $user->id;
        $englishPage->save();

        $arabicPage = new Page([
            'title' => 'Arabic Page',
            'slug' => 'arabic-page',
            'category' => 'about',
            'status' => 'published',
            'language' => 'ar',
        ]);
        $arabicPage->created_by = $user->id;
        $arabicPage->save();

        $englishPages = Page::byLanguage('en')->get();
        
        $this->assertCount(1, $englishPages);
        $this->assertEquals('en', $englishPages->first()->language);
    }

    public function test_by_category_scope_filters_pages_by_category(): void
    {
        $user = User::factory()->create();

        $aboutPage = new Page([
            'title' => 'About Page',
            'slug' => 'about-page',
            'category' => 'about',
            'status' => 'published',
            'language' => 'en',
        ]);
        $aboutPage->created_by = $user->id;
        $aboutPage->save();

        $eventsPage = new Page([
            'title' => 'Events Page',
            'slug' => 'events-page',
            'category' => 'events',
            'status' => 'published',
            'language' => 'en',
        ]);
        $eventsPage->created_by = $user->id;
        $eventsPage->save();

        $aboutPages = Page::byCategory('about')->get();
        
        $this->assertCount(1, $aboutPages);
        $this->assertEquals('about', $aboutPages->first()->category);
    }
}
