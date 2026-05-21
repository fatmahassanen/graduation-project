<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ActivitiesCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    public function test_can_view_activities_index(): void
    {
        Activity::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.activities.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.index');
        $response->assertViewHas('activities');
    }

    public function test_can_view_create_activity_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.activities.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.create');
    }

    public function test_can_create_activity_without_image(): void
    {
        $activityData = [
            'title' => 'ICT Innovation Challenge',
            'description' => 'Students won first place in the national ICT competition.',
            'category' => 'Competition',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertRedirect(route('admin.activities.index'));
        $this->assertDatabaseHas('activities', [
            'title' => 'ICT Innovation Challenge',
            'category' => 'Competition',
        ]);
    }

    public function test_can_create_activity_with_image(): void
    {
        $image = UploadedFile::fake()->image('activity.jpg');

        $activityData = [
            'title' => 'Sports Championship',
            'description' => 'University team won the regional sports championship.',
            'category' => 'Sports',
            'is_active' => true,
            'image' => $image,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertRedirect(route('admin.activities.index'));

        $activity = Activity::where('title', 'Sports Championship')->first();
        $this->assertNotNull($activity);
        $this->assertNotNull($activity->image);
        Storage::disk('public')->assertExists('activities/'.$image->hashName());
    }

    public function test_can_view_edit_activity_form(): void
    {
        $activity = Activity::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.activities.edit', $activity));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.edit');
        $response->assertViewHas('activity', $activity);
    }

    public function test_can_update_activity_without_changing_image(): void
    {
        $activity = Activity::factory()->create([
            'title' => 'Original Title',
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => $activity->description,
            'category' => $activity->category,
            'is_active' => $activity->is_active,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.activities.update', $activity), $updateData);

        $response->assertRedirect(route('admin.activities.index'));
        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_update_activity_with_new_image(): void
    {
        $oldImage = UploadedFile::fake()->image('old.jpg');
        $activity = Activity::factory()->create([
            'image' => 'activities/'.$oldImage->hashName(),
        ]);
        Storage::disk('public')->put('activities/'.$oldImage->hashName(), 'old content');

        $newImage = UploadedFile::fake()->image('new.jpg');

        $updateData = [
            'title' => $activity->title,
            'description' => $activity->description,
            'category' => $activity->category,
            'is_active' => $activity->is_active,
            'image' => $newImage,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.activities.update', $activity), $updateData);

        $response->assertRedirect(route('admin.activities.index'));

        $activity->refresh();
        $this->assertNotNull($activity->image);
        Storage::disk('public')->assertExists('activities/'.$newImage->hashName());
        Storage::disk('public')->assertMissing('activities/'.$oldImage->hashName());
    }

    public function test_can_delete_activity_without_image(): void
    {
        $activity = Activity::factory()->create(['image' => null]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.activities.destroy', $activity));

        $response->assertRedirect(route('admin.activities.index'));
        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }

    public function test_can_delete_activity_with_image(): void
    {
        $image = UploadedFile::fake()->image('activity.jpg');
        $activity = Activity::factory()->create([
            'image' => 'activities/'.$image->hashName(),
        ]);
        Storage::disk('public')->put('activities/'.$image->hashName(), 'content');

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.activities.destroy', $activity));

        $response->assertRedirect(route('admin.activities.index'));
        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
        Storage::disk('public')->assertMissing('activities/'.$image->hashName());
    }

    public function test_title_is_required(): void
    {
        $activityData = [
            'title' => '',
            'description' => 'Test description',
            'category' => 'Competition',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertSessionHasErrors('title');
    }

    public function test_description_is_required(): void
    {
        $activityData = [
            'title' => 'Test Activity',
            'description' => '',
            'category' => 'Competition',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertSessionHasErrors('description');
    }

    public function test_image_must_be_valid_format(): void
    {
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100);

        $activityData = [
            'title' => 'Test Activity',
            'description' => 'Test description',
            'category' => 'Competition',
            'image' => $invalidFile,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertSessionHasErrors('image');
    }
}
