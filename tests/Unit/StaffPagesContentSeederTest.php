<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\StaffPagesContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffPagesContentSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_profile_page_content_with_hero_and_service_cards(): void
    {
        // Arrange: Create admin user and profile page
        $admin = User::factory()->create(['role' => 'super_admin']);
        $profilePage = Page::factory()->create(['slug' => 'profile', 'language' => 'en']);

        // Act: Run the seeder
        $this->seed(StaffPagesContentSeeder::class);

        // Assert: Verify hero section exists
        $heroBlock = ContentBlock::where('page_id', $profilePage->id)
            ->where('type', 'hero')
            ->first();
        
        $this->assertNotNull($heroBlock);
        $this->assertEquals('Staff Profile & Resources', $heroBlock->content['title']);

        // Assert: Verify card grid with 6 service cards exists
        $cardGridBlock = ContentBlock::where('page_id', $profilePage->id)
            ->where('type', 'card_grid')
            ->first();
        
        $this->assertNotNull($cardGridBlock);
        $this->assertCount(6, $cardGridBlock->content['cards']);
        
        // Verify the 6 service cards
        $cardTitles = array_column($cardGridBlock->content['cards'], 'title');
        $this->assertContains('Staff Portal Login', $cardTitles);
        $this->assertContains('Update Profile', $cardTitles);
        $this->assertContains('Academic Resources', $cardTitles);
        $this->assertContains('Research Portal', $cardTitles);
        $this->assertContains('HR Services', $cardTitles);
        $this->assertContains('Support & Help', $cardTitles);
    }

    public function test_seeder_creates_staff_lms_page_content_with_login_form_and_features(): void
    {
        // Arrange: Create admin user and staff-lms page
        $admin = User::factory()->create(['role' => 'super_admin']);
        $staffLmsPage = Page::factory()->create(['slug' => 'staff-lms', 'language' => 'en']);

        // Act: Run the seeder
        $this->seed(StaffPagesContentSeeder::class);

        // Assert: Verify hero section exists
        $heroBlock = ContentBlock::where('page_id', $staffLmsPage->id)
            ->where('type', 'hero')
            ->first();
        
        $this->assertNotNull($heroBlock);
        $this->assertEquals('Staff Learning Management System', $heroBlock->content['title']);

        // Assert: Verify text block with login form and features exists
        $textBlock = ContentBlock::where('page_id', $staffLmsPage->id)
            ->where('type', 'text')
            ->first();
        
        $this->assertNotNull($textBlock);
        $this->assertStringContainsString('Staff Portal Login', $textBlock->content['body']);
        $this->assertStringContainsString('LMS Features', $textBlock->content['body']);
        $this->assertStringContainsString('Course content management', $textBlock->content['body']);
    }

    public function test_seeder_handles_missing_admin_user_gracefully(): void
    {
        // Arrange: Create pages but no admin user
        Page::factory()->create(['slug' => 'profile', 'language' => 'en']);
        Page::factory()->create(['slug' => 'staff-lms', 'language' => 'en']);

        // Act: Run the seeder
        $this->seed(StaffPagesContentSeeder::class);

        // Assert: No content blocks should be created
        $this->assertEquals(0, ContentBlock::count());
    }

    public function test_seeder_handles_missing_pages_gracefully(): void
    {
        // Arrange: Create admin user but no pages
        User::factory()->create(['role' => 'super_admin']);

        // Act: Run the seeder (should not throw exception)
        $this->seed(StaffPagesContentSeeder::class);

        // Assert: No content blocks should be created
        $this->assertEquals(0, ContentBlock::count());
    }
}
