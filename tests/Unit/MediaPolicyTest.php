<?php

namespace Tests\Unit;

use App\Models\Media;
use App\Models\User;
use App\Policies\MediaPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaPolicyTest extends TestCase
{
    use RefreshDatabase;

    private MediaPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new MediaPolicy();
    }

    public function test_all_authenticated_users_can_view_any_media()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);

        $this->assertTrue($this->policy->viewAny($superAdmin));
        $this->assertTrue($this->policy->viewAny($contentEditor));
        $this->assertTrue($this->policy->viewAny($facultyAdmin));
    }

    public function test_all_authenticated_users_can_view_media()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $media = Media::factory()->create(['uploaded_by' => $superAdmin->id]);

        $this->assertTrue($this->policy->view($superAdmin, $media));
        $this->assertTrue($this->policy->view($contentEditor, $media));
        $this->assertTrue($this->policy->view($facultyAdmin, $media));
    }

    public function test_super_admin_can_create_media()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->assertTrue($this->policy->create($superAdmin));
    }

    public function test_content_editor_can_create_media()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);

        $this->assertTrue($this->policy->create($contentEditor));
    }

    public function test_faculty_admin_can_create_media()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);

        $this->assertTrue($this->policy->create($facultyAdmin));
    }

    public function test_super_admin_can_update_all_media()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $otherUser = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $otherUser->id]);

        $this->assertTrue($this->policy->update($superAdmin, $media));
    }

    public function test_content_editor_can_update_own_media()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $contentEditor->id]);

        $this->assertTrue($this->policy->update($contentEditor, $media));
    }

    public function test_content_editor_cannot_update_others_media()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $otherUser = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $otherUser->id]);

        $this->assertFalse($this->policy->update($contentEditor, $media));
    }

    public function test_faculty_admin_can_update_own_media()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $media = Media::factory()->create(['uploaded_by' => $facultyAdmin->id]);

        $this->assertTrue($this->policy->update($facultyAdmin, $media));
    }

    public function test_faculty_admin_cannot_update_others_media()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $otherUser = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $otherUser->id]);

        $this->assertFalse($this->policy->update($facultyAdmin, $media));
    }

    public function test_super_admin_can_delete_all_media()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $otherUser = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $otherUser->id]);

        $this->assertTrue($this->policy->delete($superAdmin, $media));
    }

    public function test_content_editor_can_delete_own_media()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $contentEditor->id]);

        $this->assertTrue($this->policy->delete($contentEditor, $media));
    }

    public function test_content_editor_cannot_delete_others_media()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $otherUser = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $otherUser->id]);

        $this->assertFalse($this->policy->delete($contentEditor, $media));
    }

    public function test_faculty_admin_can_delete_own_media()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $media = Media::factory()->create(['uploaded_by' => $facultyAdmin->id]);

        $this->assertTrue($this->policy->delete($facultyAdmin, $media));
    }

    public function test_faculty_admin_cannot_delete_others_media()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $otherUser = User::factory()->create(['role' => 'content_editor']);
        $media = Media::factory()->create(['uploaded_by' => $otherUser->id]);

        $this->assertFalse($this->policy->delete($facultyAdmin, $media));
    }
}
