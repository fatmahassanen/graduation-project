<?php

namespace Tests\Feature;

use App\Models\InternalProtocol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InternalProtocolsCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_index_page_displays_protocols(): void
    {
        InternalProtocol::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get(route('admin.internal-protocols.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.internal-protocols.index');
        $response->assertViewHas('protocols');
    }

    public function test_create_page_displays_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.internal-protocols.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.internal-protocols.create');
        $response->assertViewHas('years');
    }

    public function test_store_creates_new_protocol(): void
    {
        $image = UploadedFile::fake()->image('protocol.jpg');

        $data = [
            'title' => 'Test Protocol',
            'description' => 'Test Description',
            'organization_name' => 'Test Organization',
            'year' => 2025,
            'is_active' => true,
            'order' => 1,
            'image' => $image,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.internal-protocols.store'), $data);

        $response->assertRedirect(route('admin.internal-protocols.index'));
        $response->assertSessionHas('success', 'Protocol created successfully!');

        $this->assertDatabaseHas('internal_protocols', [
            'title' => 'Test Protocol',
            'description' => 'Test Description',
            'organization_name' => 'Test Organization',
            'year' => 2025,
            'is_active' => true,
            'order' => 1,
        ]);

        Storage::disk('public')->assertExists('internal-protocols/'.$image->hashName());
    }

    public function test_store_requires_title(): void
    {
        $data = [
            'description' => 'Test Description',
            'year' => 2025,
        ];

        $response = $this->actingAs($this->user)->post(route('admin.internal-protocols.store'), $data);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_requires_year(): void
    {
        $data = [
            'title' => 'Test Protocol',
            'description' => 'Test Description',
        ];

        $response = $this->actingAs($this->user)->post(route('admin.internal-protocols.store'), $data);

        $response->assertSessionHasErrors('year');
    }

    public function test_edit_page_displays_protocol(): void
    {
        $protocol = InternalProtocol::factory()->create();

        $response = $this->actingAs($this->user)->get(route('admin.internal-protocols.edit', $protocol));

        $response->assertStatus(200);
        $response->assertViewIs('admin.internal-protocols.edit');
        $response->assertViewHas('internalProtocol', $protocol);
        $response->assertViewHas('years');
    }

    public function test_update_modifies_protocol(): void
    {
        $protocol = InternalProtocol::factory()->create([
            'title' => 'Old Title',
            'year' => 2024,
        ]);

        $data = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'organization_name' => 'Updated Organization',
            'year' => 2025,
            'is_active' => true,
            'order' => 2,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.internal-protocols.update', $protocol), $data);

        $response->assertRedirect(route('admin.internal-protocols.index'));
        $response->assertSessionHas('success', 'Protocol updated successfully!');

        $this->assertDatabaseHas('internal_protocols', [
            'id' => $protocol->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'organization_name' => 'Updated Organization',
            'year' => 2025,
            'is_active' => true,
            'order' => 2,
        ]);
    }

    public function test_update_replaces_image(): void
    {
        $oldImage = UploadedFile::fake()->image('old.jpg');
        $protocol = InternalProtocol::factory()->create([
            'image' => 'internal-protocols/'.$oldImage->hashName(),
        ]);

        Storage::disk('public')->put('internal-protocols/'.$oldImage->hashName(), 'old content');

        $newImage = UploadedFile::fake()->image('new.jpg');

        $data = [
            'title' => $protocol->title,
            'year' => $protocol->year,
            'image' => $newImage,
        ];

        $response = $this->actingAs($this->user)->put(route('admin.internal-protocols.update', $protocol), $data);

        $response->assertRedirect(route('admin.internal-protocols.index'));

        Storage::disk('public')->assertMissing('internal-protocols/'.$oldImage->hashName());
        Storage::disk('public')->assertExists('internal-protocols/'.$newImage->hashName());
    }

    public function test_destroy_deletes_protocol(): void
    {
        $protocol = InternalProtocol::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('admin.internal-protocols.destroy', $protocol));

        $response->assertRedirect(route('admin.internal-protocols.index'));
        $response->assertSessionHas('success', 'Protocol deleted successfully!');

        $this->assertDatabaseMissing('internal_protocols', [
            'id' => $protocol->id,
        ]);
    }

    public function test_destroy_deletes_image(): void
    {
        $image = UploadedFile::fake()->image('protocol.jpg');
        $protocol = InternalProtocol::factory()->create([
            'image' => 'internal-protocols/'.$image->hashName(),
        ]);

        Storage::disk('public')->put('internal-protocols/'.$image->hashName(), 'content');

        $response = $this->actingAs($this->user)->delete(route('admin.internal-protocols.destroy', $protocol));

        $response->assertRedirect(route('admin.internal-protocols.index'));

        Storage::disk('public')->assertMissing('internal-protocols/'.$image->hashName());
    }

    public function test_frontend_displays_protocols_grouped_by_year(): void
    {
        InternalProtocol::factory()->create(['year' => 2025, 'is_active' => true]);
        InternalProtocol::factory()->create(['year' => 2024, 'is_active' => true]);
        InternalProtocol::factory()->create(['year' => 2025, 'is_active' => true]);

        $response = $this->get(route('internalprotocols'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.internal-protocols');
        $response->assertViewHas('protocols');
    }
}
