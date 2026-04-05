<?php

namespace Tests\Unit;

use App\Models\AuditLog;
use App\Models\ContactSubmission;
use App\Models\Event;
use App\Models\Media;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportingModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_media_model_can_be_created(): void
    {
        $user = User::factory()->create();
        
        $media = Media::create([
            'filename' => 'test-image.jpg',
            'original_name' => 'Test Image.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024000,
            'path' => '/storage/media/test-image.jpg',
            'uploaded_by' => $user->id,
            'alt_text' => 'Test image description',
        ]);

        $this->assertDatabaseHas('media', [
            'filename' => 'test-image.jpg',
            'original_name' => 'Test Image.jpg',
        ]);
        
        $this->assertEquals($user->id, $media->uploader->id);
    }

    public function test_event_model_can_be_created(): void
    {
        $user = User::factory()->create();
        
        $event = Event::create([
            'title' => 'Tech Conference 2024',
            'description' => 'Annual technology conference',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(9),
            'location' => 'Main Auditorium',
            'category' => 'conference',
            'is_recurring' => false,
            'language' => 'en',
            'status' => 'published',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('events', [
            'title' => 'Tech Conference 2024',
            'category' => 'conference',
        ]);
        
        $this->assertEquals($user->id, $event->creator->id);
    }

    public function test_news_model_can_be_created(): void
    {
        $user = User::factory()->create();
        
        $news = News::create([
            'title' => 'University Wins Award',
            'slug' => 'university-wins-award',
            'excerpt' => 'Our university has been recognized',
            'body' => 'Full article content here...',
            'author_id' => $user->id,
            'category' => 'achievement',
            'is_featured' => true,
            'language' => 'en',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('news', [
            'title' => 'University Wins Award',
            'slug' => 'university-wins-award',
        ]);
        
        $this->assertEquals($user->id, $news->author->id);
        $this->assertTrue($news->is_featured);
    }

    public function test_contact_submission_model_can_be_created(): void
    {
        $submission = ContactSubmission::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'subject' => 'Inquiry about admissions',
            'message' => 'I would like to know more about your programs',
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'is_read' => false,
        ]);

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $this->assertFalse($submission->is_read);
    }

    public function test_contact_submission_can_be_marked_as_read(): void
    {
        $user = User::factory()->create();
        $submission = ContactSubmission::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message',
            'ip_address' => '192.168.1.1',
            'is_read' => false,
        ]);

        $submission->markAsRead($user->id);

        $this->assertTrue($submission->is_read);
        $this->assertEquals($user->id, $submission->read_by);
        $this->assertNotNull($submission->read_at);
    }

    public function test_audit_log_model_can_be_created(): void
    {
        $user = User::factory()->create();
        
        $auditLog = AuditLog::create([
            'user_id' => $user->id,
            'action' => 'created',
            'model_type' => 'App\Models\Page',
            'model_id' => 1,
            'old_values' => null,
            'new_values' => ['title' => 'New Page'],
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'created',
            'model_type' => 'App\Models\Page',
        ]);
        
        $this->assertEquals($user->id, $auditLog->user->id);
    }

    public function test_event_scopes_work_correctly(): void
    {
        $user = User::factory()->create();
        
        Event::create([
            'title' => 'Published Conference',
            'description' => 'Test',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'category' => 'conference',
            'status' => 'published',
            'created_by' => $user->id,
        ]);
        
        Event::create([
            'title' => 'Draft Workshop',
            'description' => 'Test',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(11),
            'category' => 'workshop',
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        $this->assertEquals(1, Event::published()->count());
        $this->assertEquals(1, Event::byCategory('conference')->count());
        $this->assertEquals(2, Event::upcoming()->count());
    }

    public function test_news_scopes_work_correctly(): void
    {
        $user = User::factory()->create();
        
        News::create([
            'title' => 'Featured News',
            'slug' => 'featured-news',
            'excerpt' => 'Test',
            'body' => 'Test body',
            'author_id' => $user->id,
            'category' => 'announcement',
            'is_featured' => true,
            'status' => 'published',
        ]);
        
        News::create([
            'title' => 'Regular News',
            'slug' => 'regular-news',
            'excerpt' => 'Test',
            'body' => 'Test body',
            'author_id' => $user->id,
            'category' => 'research',
            'is_featured' => false,
            'status' => 'draft',
        ]);

        $this->assertEquals(1, News::published()->count());
        $this->assertEquals(1, News::featured()->count());
        $this->assertEquals(1, News::byCategory('announcement')->count());
    }

    public function test_contact_submission_scopes_work_correctly(): void
    {
        ContactSubmission::create([
            'name' => 'Read User',
            'email' => 'read@example.com',
            'subject' => 'Test',
            'message' => 'Test',
            'ip_address' => '192.168.1.1',
            'is_read' => true,
        ]);
        
        ContactSubmission::create([
            'name' => 'Unread User',
            'email' => 'unread@example.com',
            'subject' => 'Test',
            'message' => 'Test',
            'ip_address' => '192.168.1.1',
            'is_read' => false,
        ]);

        $this->assertEquals(1, ContactSubmission::read()->count());
        $this->assertEquals(1, ContactSubmission::unread()->count());
    }
}
