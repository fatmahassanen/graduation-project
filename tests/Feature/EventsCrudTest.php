<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventsCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $this->user = User::factory()->create();

        // Fake storage for testing
        Storage::fake('public');
    }

    public function test_events_index_page_displays_events(): void
    {
        // Create some test events
        Event::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('admin.events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.events.index');
        $response->assertViewHas('events');
    }

    public function test_events_create_page_loads(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.events.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.events.create');
    }

    public function test_can_store_new_event_with_image(): void
    {
        $image = UploadedFile::fake()->image('event.jpg');

        $response = $this->actingAs($this->user)
            ->post(route('admin.events.store'), [
                'title' => 'Test Event',
                'description' => 'This is a test event description',
                'image' => $image,
                'link' => '/test-event',
            ]);

        $response->assertRedirect(route('admin.events.index'));
        $response->assertSessionHas('success', 'Event added successfully!');

        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'description' => 'This is a test event description',
            'link' => '/test-event',
        ]);

        // Verify image was stored
        $event = Event::where('title', 'Test Event')->first();
        Storage::disk('public')->assertExists($event->image);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.events.store'), []);

        $response->assertSessionHasErrors(['title', 'description', 'image', 'link']);
    }

    public function test_store_validates_image_format(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->user)
            ->post(route('admin.events.store'), [
                'title' => 'Test Event',
                'description' => 'Description',
                'image' => $file,
                'link' => '/test',
            ]);

        $response->assertSessionHasErrors(['image']);
    }

    public function test_events_edit_page_loads(): void
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('admin.events.edit', $event));

        $response->assertStatus(200);
        $response->assertViewIs('admin.events.edit');
        $response->assertViewHas('event', $event);
    }

    public function test_can_update_event_without_changing_image(): void
    {
        $event = Event::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original Description',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('admin.events.update', $event), [
                'title' => 'Updated Title',
                'description' => 'Updated Description',
                'link' => $event->link,
            ]);

        $response->assertRedirect(route('admin.events.index'));
        $response->assertSessionHas('success', 'Event updated successfully!');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }

    public function test_can_update_event_with_new_image(): void
    {
        $oldImage = UploadedFile::fake()->image('old.jpg');

        $event = Event::factory()->create([
            'image' => $oldImage->store('events', 'public'),
        ]);

        $oldImagePath = $event->image;
        Storage::disk('public')->put($oldImagePath, 'old content');

        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($this->user)
            ->put(route('admin.events.update', $event), [
                'title' => $event->title,
                'description' => $event->description,
                'image' => $newImage,
                'link' => $event->link,
            ]);

        $response->assertRedirect(route('admin.events.index'));

        $event->refresh();

        // Verify new image was stored
        Storage::disk('public')->assertExists($event->image);

        // Verify old image was deleted
        Storage::disk('public')->assertMissing($oldImagePath);
    }

    public function test_can_delete_event_and_image(): void
    {
        $image = UploadedFile::fake()->image('event.jpg');
        $imagePath = $image->store('events', 'public');

        $event = Event::factory()->create([
            'image' => $imagePath,
        ]);

        Storage::disk('public')->put($imagePath, 'test content');

        $response = $this->actingAs($this->user)
            ->delete(route('admin.events.destroy', $event));

        $response->assertRedirect(route('admin.events.index'));
        $response->assertSessionHas('success', 'Event deleted!');

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);

        // Verify image was deleted
        Storage::disk('public')->assertMissing($imagePath);
    }
}
