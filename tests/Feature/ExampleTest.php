<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Page;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Create a home page for the test
        $admin = User::factory()->create(['role' => 'super_admin']);
        Page::factory()->create([
            'slug' => 'home',
            'language' => 'en',
            'status' => 'published',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
