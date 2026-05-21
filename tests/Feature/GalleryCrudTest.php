<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_gallery_index_page_displays_gallery_items(): void
    {
        Gallery::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('admin.gallery.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.gallery.index');
        $response->assertViewHas('galleries');
    }

    public function test_gallery_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.gallery.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.gallery.create');
    }

    public function test_can_store_new_gallery_item_with_image(): void
    {
        $image = UploadedFile::fake()->image('test-gallery.jpg');

        $response = $this->actingAs($this->user)
            ->post(route('admin.gallery.store'), [
                'image' => $image,
                'is_active' => true,
            ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galleries', [
            'title' => 'Test Gallery',
            'is_active' => true,
        ]);

        Storage::disk('public')->assertExists('gallery/'.$image->hashName());
    }

    public function test_can_store_gallery_with_custom_title_and_category(): void
    {
        $image = UploadedFile::fake()->image('test.jpg');

        $response = $this->actingAs($this->user)
            ->post(route('admin.gallery.store'), [
                'title' => 'Custom Title',
                'image' => $image,
                'category' => 'Campus',
                'is_active' => true,
            ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseHas('galleries', [
            'title' => 'Custom Title',
            'category' => 'Campus',
            'is_active' => true,
        ]);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.gallery.store'), []);

        $response->assertSessionHasErrors(['image']);
    }

    public function test_store_validates_image_format(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->user)
            ->post(route('admin.gallery.store'), [
                'image' => $file,
            ]);

        $response->assertSessionHasErrors(['image']);
    }

    public function test_gallery_edit_page_loads(): void
    {
        $gallery = Gallery::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('admin.gallery.edit', $gallery));

        $response->assertStatus(200);
        $response->assertViewIs('admin.gallery.edit');
        $response->assertViewHas('gallery', $gallery);
    }

    public function test_can_update_gallery_item_without_changing_image(): void
    {
        $gallery = Gallery::factory()->create([
            'title' => 'Original Title',
            'image' => 'gallery/original.jpg',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('admin.gallery.update', $gallery), [
                'title' => 'Updated Title',
                'category' => 'Events',
                'is_active' => true,
            ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'title' => 'Updated Title',
            'category' => 'Events',
            'image' => 'gallery/original.jpg',
        ]);
    }

    public function test_can_update_gallery_item_with_new_image(): void
    {
        $gallery = Gallery::factory()->create([
            'image' => null,
        ]);

        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($this->user)
            ->put(route('admin.gallery.update', $gallery), [
                'title' => $gallery->title,
                'category' => $gallery->category,
                'image' => $newImage,
                'is_active' => true,
            ]);

        $response->assertRedirect(route('admin.gallery.index'));

        Storage::disk('public')->assertExists('gallery/'.$newImage->hashName());

        $gallery->refresh();
        $this->assertStringContainsString('gallery/', $gallery->image);
    }

    public function test_can_delete_gallery_item_and_image(): void
    {
        $image = UploadedFile::fake()->image('test.jpg');

        $gallery = Gallery::factory()->create([
            'image' => null,
        ]);

        // Upload image through the update method to ensure it exists in fake storage
        $this->actingAs($this->user)
            ->put(route('admin.gallery.update', $gallery), [
                'title' => $gallery->title,
                'category' => $gallery->category,
                'image' => $image,
                'is_active' => true,
            ]);

        $gallery->refresh();
        $imagePath = $gallery->image;

        Storage::disk('public')->assertExists($imagePath);

        $response = $this->actingAs($this->user)
            ->delete(route('admin.gallery.destroy', $gallery));

        $response->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }
}
