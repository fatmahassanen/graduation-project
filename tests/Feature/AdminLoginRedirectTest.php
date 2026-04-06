<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_login_redirects_to_admin_dashboard(): void
    {
        // Create a super admin user
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'failed_login_attempts' => 0,
        ]);

        // Attempt to login
        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        // Assert redirect to admin dashboard
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_controller_has_redirect_path_method(): void
    {
        $controller = new \App\Http\Controllers\Auth\LoginController();
        
        // Use reflection to access the protected method
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('redirectPath');
        $method->setAccessible(true);
        
        $redirectPath = $method->invoke($controller);
        
        $this->assertEquals('/admin', $redirectPath);
    }
}
