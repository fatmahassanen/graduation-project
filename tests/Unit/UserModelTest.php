<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_role_and_faculty_category(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'faculty_admin',
            'faculty_category' => 'engineering',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'faculty_admin',
            'faculty_category' => 'engineering',
        ]);
    }

    public function test_is_super_admin_returns_true_for_super_admin_role(): void
    {
        $user = User::factory()->create(['role' => 'super_admin']);

        $this->assertTrue($user->isSuperAdmin());
        $this->assertFalse($user->isContentEditor());
        $this->assertFalse($user->isFacultyAdmin());
    }

    public function test_is_content_editor_returns_true_for_content_editor_role(): void
    {
        $user = User::factory()->create(['role' => 'content_editor']);

        $this->assertTrue($user->isContentEditor());
        $this->assertFalse($user->isSuperAdmin());
        $this->assertFalse($user->isFacultyAdmin());
    }

    public function test_is_faculty_admin_returns_true_for_faculty_admin_role(): void
    {
        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'engineering',
        ]);

        $this->assertTrue($user->isFacultyAdmin());
        $this->assertFalse($user->isSuperAdmin());
        $this->assertFalse($user->isContentEditor());
    }

    public function test_is_locked_out_returns_true_when_locked_until_is_future(): void
    {
        $user = User::factory()->create([
            'locked_until' => now()->addHours(2),
        ]);

        $this->assertTrue($user->isLockedOut());
    }

    public function test_is_locked_out_returns_false_when_locked_until_is_past(): void
    {
        $user = User::factory()->create([
            'locked_until' => now()->subHours(2),
        ]);

        $this->assertFalse($user->isLockedOut());
    }

    public function test_is_locked_out_returns_false_when_locked_until_is_null(): void
    {
        $user = User::factory()->create([
            'locked_until' => null,
        ]);

        $this->assertFalse($user->isLockedOut());
    }

    public function test_failed_login_attempts_can_be_incremented(): void
    {
        $user = User::factory()->create([
            'failed_login_attempts' => 0,
        ]);

        $user->update(['failed_login_attempts' => $user->failed_login_attempts + 1]);

        $this->assertEquals(1, $user->fresh()->failed_login_attempts);
    }

    public function test_locked_until_is_cast_to_datetime(): void
    {
        $lockTime = now()->addHours(1);
        $user = User::factory()->create([
            'locked_until' => $lockTime,
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->locked_until);
        $this->assertEquals($lockTime->timestamp, $user->locked_until->timestamp);
    }
}
