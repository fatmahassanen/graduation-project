<?php

namespace Tests\Unit;

use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use App\Policies\ContentBlockPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentBlockPolicyTest extends TestCase
{
    use RefreshDatabase;

    private ContentBlockPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new ContentBlockPolicy();
    }

    public function test_super_admin_can_view_any_content_blocks()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->assertTrue($this->policy->viewAny($superAdmin));
    }

    public function test_content_editor_can_view_any_content_blocks()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);

        $this->assertTrue($this->policy->viewAny($contentEditor));
    }

    public function test_faculty_admin_can_view_any_content_blocks()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);

        $this->assertTrue($this->policy->viewAny($facultyAdmin));
    }

    public function test_super_admin_can_view_all_content_blocks()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $page = Page::factory()->create(['category' => 'admissions']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->view($superAdmin, $block));
    }

    public function test_content_editor_can_view_all_content_blocks()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $page = Page::factory()->create(['category' => 'admissions']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->view($contentEditor, $block));
    }

    public function test_faculty_admin_can_view_own_faculty_content_blocks()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->view($facultyAdmin, $block));
    }

    public function test_faculty_admin_cannot_view_other_faculty_content_blocks()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'admissions']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertFalse($this->policy->view($facultyAdmin, $block));
    }

    public function test_super_admin_can_create_content_blocks()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->assertTrue($this->policy->create($superAdmin));
    }

    public function test_content_editor_can_create_content_blocks()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);

        $this->assertTrue($this->policy->create($contentEditor));
    }

    public function test_faculty_admin_can_create_content_blocks()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);

        $this->assertTrue($this->policy->create($facultyAdmin));
    }

    public function test_super_admin_can_update_all_content_blocks()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $page = Page::factory()->create(['category' => 'admissions']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->update($superAdmin, $block));
    }

    public function test_content_editor_can_update_all_content_blocks()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $page = Page::factory()->create(['category' => 'admissions']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->update($contentEditor, $block));
    }

    public function test_faculty_admin_can_update_own_faculty_content_blocks()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->update($facultyAdmin, $block));
    }

    public function test_faculty_admin_cannot_update_other_faculty_content_blocks()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'admissions']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertFalse($this->policy->update($facultyAdmin, $block));
    }

    public function test_only_super_admin_can_delete_content_blocks()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);
        $block = ContentBlock::factory()->create(['page_id' => $page->id]);

        $this->assertTrue($this->policy->delete($superAdmin, $block));
        $this->assertFalse($this->policy->delete($contentEditor, $block));
        $this->assertFalse($this->policy->delete($facultyAdmin, $block));
    }
}
