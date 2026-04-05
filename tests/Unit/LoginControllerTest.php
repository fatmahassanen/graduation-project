<?php

namespace Tests\Unit;

use App\Exceptions\AccountLockedException;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private LoginController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new LoginController();
    }

    public function test_successful_login_resets_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 3,
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->controller->login($request);

        $user->refresh();
        $this->assertEquals(0, $user->failed_login_attempts);
        $this->assertNull($user->locked_until);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Auth::check());
    }

    public function test_failed_login_increments_counter(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 0,
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        try {
            $this->controller->login($request);
            $this->fail('Expected ValidationException was not thrown');
        } catch (ValidationException $e) {
            $user->refresh();
            $this->assertEquals(1, $user->failed_login_attempts);
            $this->assertFalse(Auth::check());
        }
    }

    public function test_account_locks_after_5_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 4,
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        try {
            $this->controller->login($request);
            $this->fail('Expected AccountLockedException was not thrown');
        } catch (AccountLockedException $e) {
            $user->refresh();
            $this->assertEquals(5, $user->failed_login_attempts);
            $this->assertNotNull($user->locked_until);
            $this->assertTrue($user->locked_until->isFuture());
            $this->assertFalse(Auth::check());
        }
    }

    public function test_locked_account_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 5,
            'locked_until' => now()->addMinutes(10),
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        try {
            $this->controller->login($request);
            $this->fail('Expected AccountLockedException was not thrown');
        } catch (AccountLockedException $e) {
            $this->assertFalse(Auth::check());
            $this->assertEquals('Account locked for 15 minutes due to failed login attempts', $e->getMessage());
        }
    }

    public function test_account_unlocks_after_15_minutes(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 5,
            'locked_until' => now()->subMinutes(1), // Lockout expired
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->controller->login($request);

        $user->refresh();
        $this->assertEquals(0, $user->failed_login_attempts);
        $this->assertNull($user->locked_until);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(Auth::check());
    }

    public function test_lockout_timer_resets_on_successful_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 3,
            'locked_until' => null,
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->controller->login($request);

        $user->refresh();
        $this->assertEquals(0, $user->failed_login_attempts);
        $this->assertNull($user->locked_until);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_invalid_email_throws_validation_exception(): void
    {
        $request = Request::create('/login', 'POST', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $this->expectException(ValidationException::class);
        $this->controller->login($request);
    }

    public function test_multiple_failed_attempts_increment_correctly(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'failed_login_attempts' => 0,
        ]);

        $request = Request::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // First failed attempt
        try {
            $this->controller->login($request);
        } catch (ValidationException $e) {
            // Expected
        }

        $user->refresh();
        $this->assertEquals(1, $user->failed_login_attempts);

        // Second failed attempt
        try {
            $this->controller->login($request);
        } catch (ValidationException $e) {
            // Expected
        }

        $user->refresh();
        $this->assertEquals(2, $user->failed_login_attempts);
    }

    public function test_logout_invalidates_session(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $request = Request::create('/logout', 'POST');
        $request->setLaravelSession($this->app['session.store']);

        $response = $this->controller->logout($request);

        $this->assertFalse(Auth::check());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_account_locked_exception_returns_423_status(): void
    {
        $exception = new AccountLockedException();
        $response = $exception->render();

        $this->assertEquals(423, $response->getStatusCode());
        $data = $response->getData(true);
        $this->assertTrue($data['locked']);
        $this->assertStringContainsString('Account locked', $data['error']);
    }
}
