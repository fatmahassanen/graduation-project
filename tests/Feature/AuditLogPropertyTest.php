<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\ContentBlock;
use App\Models\Media;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 22: Audit Log Creation on Actions
     * 
     * For any content creation, update, or deletion action, an AuditLog entry SHALL be created
     * with user, action, model details, and timestamp.
     * 
     * Validates: Requirements 8.1
     */
    public function test_property_22_audit_log_creation_on_actions(): void
    {
        // Authenticate a user
        $user = User::factory()->create(['role' => 'super_admin']);
        $this->actingAs($user);

        // Clear existing audit logs
        AuditLog::truncate();

        // Test 1: Page creation creates audit log
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'created',
            'model_type' => Page::class,
            'model_id' => $page->id,
        ]);

        $createdLog = AuditLog::where('model_id', $page->id)
            ->where('model_type', Page::class)
            ->where('action', 'created')
            ->first();

        $this->assertNotNull($createdLog);
        $this->assertNotNull($createdLog->ip_address);
        $this->assertNotNull($createdLog->user_agent);
        $this->assertNotNull($createdLog->created_at);

        // Test 2: Page update creates audit log
        $page->update(['title' => 'Updated Test Page']);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'updated',
            'model_type' => Page::class,
            'model_id' => $page->id,
        ]);

        $updatedLog = AuditLog::where('model_id', $page->id)
            ->where('model_type', Page::class)
            ->where('action', 'updated')
            ->first();

        $this->assertNotNull($updatedLog);
        $this->assertNotNull($updatedLog->old_values);
        $this->assertNotNull($updatedLog->new_values);
        $this->assertEquals('Test Page', $updatedLog->old_values['title']);
        $this->assertEquals('Updated Test Page', $updatedLog->new_values['title']);

        // Test 3: Page deletion creates audit log
        $pageId = $page->id;
        $page->delete();

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'deleted',
            'model_type' => Page::class,
            'model_id' => $pageId,
        ]);

        // Test 4: ContentBlock creation creates audit log
        $block = ContentBlock::create([
            'page_id' => Page::factory()->create(['created_by' => $user->id])->id,
            'type' => 'text',
            'content' => ['content' => 'Test content'],
            'display_order' => 0,
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'created',
            'model_type' => ContentBlock::class,
            'model_id' => $block->id,
        ]);

        // Test 5: Media creation creates audit log
        $media = Media::create([
            'filename' => 'test-image.jpg',
            'original_name' => 'test image.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 1024,
            'path' => '/storage/media/test-image.jpg',
            'uploaded_by' => $user->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'created',
            'model_type' => Media::class,
            'model_id' => $media->id,
        ]);
    }

    /**
     * Property 23: Audit Log Chronological Ordering
     * 
     * For any set of audit log entries, retrieving them SHALL return them ordered
     * by created_at in descending (most recent first) order.
     * 
     * Validates: Requirements 8.6
     */
    public function test_property_23_audit_log_chronological_ordering(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $this->actingAs($user);

        // Clear existing audit logs
        AuditLog::truncate();

        // Create multiple pages with slight delays to ensure different timestamps
        $page1 = Page::create([
            'title' => 'First Page',
            'slug' => 'first-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        usleep(10000); // 10ms delay

        $page2 = Page::create([
            'title' => 'Second Page',
            'slug' => 'second-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        usleep(10000); // 10ms delay

        $page3 = Page::create([
            'title' => 'Third Page',
            'slug' => 'third-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Retrieve audit logs ordered by created_at descending
        $logs = AuditLog::orderBy('created_at', 'desc')->get();

        $this->assertGreaterThanOrEqual(3, $logs->count());

        // Verify chronological ordering (most recent first)
        $timestamps = $logs->pluck('created_at')->toArray();
        $sortedTimestamps = $timestamps;
        rsort($sortedTimestamps);

        $this->assertEquals($sortedTimestamps, $timestamps, 'Audit logs should be ordered by created_at descending');

        // Verify the most recent log is for the third page
        $mostRecentLog = $logs->first();
        $this->assertEquals($page3->id, $mostRecentLog->model_id);
        $this->assertEquals(Page::class, $mostRecentLog->model_type);
    }

    /**
     * Property 22 Extended: Audit logs capture IP and user agent
     */
    public function test_property_22_audit_logs_capture_ip_and_user_agent(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $this->actingAs($user);

        AuditLog::truncate();

        // Create a page
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Retrieve the audit log
        $log = AuditLog::where('model_id', $page->id)
            ->where('model_type', Page::class)
            ->first();

        // Verify IP address and user agent are captured
        $this->assertNotNull($log->ip_address);
        $this->assertNotNull($log->user_agent);
        $this->assertIsString($log->ip_address);
        $this->assertIsString($log->user_agent);
    }

    /**
     * Property 22 Extended: Audit logs filter sensitive fields
     */
    public function test_property_22_audit_logs_filter_sensitive_fields(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
            'password' => bcrypt('password123'),
        ]);
        $this->actingAs($user);

        AuditLog::truncate();

        // Update user (which should trigger audit log)
        $user->update(['name' => 'Updated Name']);

        // Retrieve the audit log
        $log = AuditLog::where('model_id', $user->id)
            ->where('model_type', User::class)
            ->where('action', 'updated')
            ->first();

        $this->assertNotNull($log);

        // Verify sensitive fields are not in old_values or new_values
        $this->assertArrayNotHasKey('password', $log->old_values ?? []);
        $this->assertArrayNotHasKey('password', $log->new_values ?? []);
        $this->assertArrayNotHasKey('remember_token', $log->old_values ?? []);
        $this->assertArrayNotHasKey('remember_token', $log->new_values ?? []);
    }

    /**
     * Property 22 Extended: No audit log when no authenticated user
     */
    public function test_property_22_no_audit_log_without_authentication(): void
    {
        // Create a user but don't authenticate
        $user = User::factory()->create(['role' => 'super_admin']);
        
        AuditLog::truncate();

        // Create a page without authentication (e.g., during seeding)
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'category' => 'admissions',
            'status' => 'draft',
            'language' => 'en',
            'created_by' => $user->id,
        ]);

        // Verify no audit log was created
        $logCount = AuditLog::where('model_id', $page->id)
            ->where('model_type', Page::class)
            ->count();

        $this->assertEquals(0, $logCount, 'No audit log should be created when no user is authenticated');
    }
}
