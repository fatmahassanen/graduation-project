<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\User;
use App\Policies\PagePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagePolicyTest extends TestCase
{
    use RefreshDatabase;

    private PagePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PagePolicy();
    }

    public function test_super_admin_can_view_any_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->assertTrue($this->policy->viewAny($superAdmin));
    }

    public function test_content_editor_can_view_any_pages()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);

        $this->assertTrue($this->policy->viewAny($contentEditor));
    }

    public function test_faculty_admin_can_view_any_pages()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);

        $this->assertTrue($this->policy->viewAny($facultyAdmin));
    }

    public function test_super_admin_can_view_all_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $page = Page::factory()->create(['category' => 'admissions']);

        $this->assertTrue($this->policy->view($superAdmin, $page));
    }

    public function test_content_editor_can_view_all_pages()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $page = Page::factory()->create(['category' => 'admissions']);

        $this->assertTrue($this->policy->view($contentEditor, $page));
    }

    public function test_faculty_admin_can_view_own_faculty_pages()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);

        $this->assertTrue($this->policy->view($facultyAdmin, $page));
    }

    public function test_faculty_admin_cannot_view_other_faculty_pages()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'admissions']);

        $this->assertFalse($this->policy->view($facultyAdmin, $page));
    }

    public function test_super_admin_can_create_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->assertTrue($this->policy->create($superAdmin));
    }

    public function test_content_editor_can_create_pages()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);

        $this->assertTrue($this->policy->create($contentEditor));
    }

    public function test_faculty_admin_can_create_pages()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);

        $this->assertTrue($this->policy->create($facultyAdmin));
    }

    public function test_super_admin_can_update_all_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $page = Page::factory()->create(['category' => 'admissions']);

        $this->assertTrue($this->policy->update($superAdmin, $page));
    }

    public function test_content_editor_can_update_all_pages()
    {
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $page = Page::factory()->create(['category' => 'admissions']);

        $this->assertTrue($this->policy->update($contentEditor, $page));
    }

    public function test_faculty_admin_can_update_own_faculty_pages()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);

        $this->assertTrue($this->policy->update($facultyAdmin, $page));
    }

    public function test_faculty_admin_cannot_update_other_faculty_pages()
    {
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'admissions']);

        $this->assertFalse($this->policy->update($facultyAdmin, $page));
    }

    public function test_only_super_admin_can_delete_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);

        $this->assertTrue($this->policy->delete($superAdmin, $page));
        $this->assertFalse($this->policy->delete($contentEditor, $page));
        $this->assertFalse($this->policy->delete($facultyAdmin, $page));
    }

    public function test_only_super_admin_can_publish_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);

        $this->assertTrue($this->policy->publish($superAdmin, $page));
        $this->assertFalse($this->policy->publish($contentEditor, $page));
        $this->assertFalse($this->policy->publish($facultyAdmin, $page));
    }

    public function test_only_super_admin_can_restore_pages()
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $contentEditor = User::factory()->create(['role' => 'content_editor']);
        $facultyAdmin = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties',
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);

        $this->assertTrue($this->policy->restore($superAdmin, $page));
        $this->assertFalse($this->policy->restore($contentEditor, $page));
        $this->assertFalse($this->policy->restore($facultyAdmin, $page));
    }
}
