<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TrainingsCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        Storage::fake('public');
    }

    public function test_can_view_trainings_index(): void
    {
        Training::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.trainings.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainings.index');
        $response->assertViewHas('trainings');
    }

    public function test_can_view_create_training_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.trainings.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainings.create');
    }

    public function test_can_create_training_without_image(): void
    {
        $trainingData = [
            'title' => 'Advanced Laravel Development',
            'description' => 'Learn advanced Laravel concepts',
            'instructor' => 'John Doe',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-05',
            'location' => 'Main Campus',
            'duration' => 5,
            'capacity' => 30,
            'category' => 'Technical',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.trainings.store'), $trainingData);

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseHas('trainings', [
            'title' => 'Advanced Laravel Development',
            'instructor' => 'John Doe',
        ]);
    }

    public function test_can_create_training_with_image(): void
    {
        $image = UploadedFile::fake()->image('training.jpg');

        $trainingData = [
            'title' => 'Web Design Fundamentals',
            'description' => 'Learn web design basics',
            'instructor' => 'Jane Smith',
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-10',
            'location' => 'Design Lab',
            'duration' => 10,
            'capacity' => 20,
            'category' => 'Technical',
            'is_active' => true,
            'image' => $image,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.trainings.store'), $trainingData);

        $response->assertRedirect(route('admin.trainings.index'));

        $training = Training::where('title', 'Web Design Fundamentals')->first();
        $this->assertNotNull($training);
        $this->assertNotNull($training->image);
        Storage::disk('public')->assertExists('trainings/'.$image->hashName());
    }

    public function test_can_create_training_with_multiple_images(): void
    {
        $image1 = UploadedFile::fake()->image('diamond1.jpg');
        $image2 = UploadedFile::fake()->image('diamond2.jpg');
        $image3 = UploadedFile::fake()->image('diamond3.jpg');

        $trainingData = [
            'title' => 'Advanced Programming',
            'description' => 'Learn advanced programming concepts',
            'instructor' => 'John Developer',
            'start_date' => '2026-07-01',
            'end_date' => '2026-07-15',
            'location' => 'Tech Lab',
            'duration' => 15,
            'capacity' => 25,
            'category' => 'Technical',
            'is_active' => true,
            'images' => [$image1, $image2, $image3],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.trainings.store'), $trainingData);

        $response->assertRedirect(route('admin.trainings.index'));

        $training = Training::where('title', 'Advanced Programming')->first();
        $this->assertNotNull($training);
        $this->assertNotNull($training->images);
        $this->assertCount(3, $training->images);
        Storage::disk('public')->assertExists('trainings/'.$image1->hashName());
        Storage::disk('public')->assertExists('trainings/'.$image2->hashName());
        Storage::disk('public')->assertExists('trainings/'.$image3->hashName());
    }

    public function test_can_view_edit_training_form(): void
    {
        $training = Training::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.trainings.edit', $training));

        $response->assertStatus(200);
        $response->assertViewIs('admin.trainings.edit');
        $response->assertViewHas('training', $training);
    }

    public function test_can_update_training_without_changing_image(): void
    {
        $training = Training::factory()->create([
            'title' => 'Original Title',
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => $training->description,
            'instructor' => $training->instructor,
            'start_date' => $training->start_date ? $training->start_date->format('Y-m-d') : null,
            'end_date' => $training->end_date ? $training->end_date->format('Y-m-d') : null,
            'location' => $training->location,
            'duration' => $training->duration,
            'capacity' => $training->capacity,
            'category' => $training->category,
            'is_active' => $training->is_active,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.trainings.update', $training), $updateData);

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseHas('trainings', [
            'id' => $training->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_update_training_with_new_image(): void
    {
        $oldImage = UploadedFile::fake()->image('old.jpg');
        $training = Training::factory()->create([
            'image' => 'trainings/'.$oldImage->hashName(),
        ]);
        Storage::disk('public')->put('trainings/'.$oldImage->hashName(), 'old content');

        $newImage = UploadedFile::fake()->image('new.jpg');

        $updateData = [
            'title' => $training->title,
            'description' => $training->description,
            'instructor' => $training->instructor,
            'start_date' => $training->start_date ? $training->start_date->format('Y-m-d') : null,
            'end_date' => $training->end_date ? $training->end_date->format('Y-m-d') : null,
            'location' => $training->location,
            'duration' => $training->duration,
            'capacity' => $training->capacity,
            'category' => $training->category,
            'is_active' => $training->is_active,
            'image' => $newImage,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.trainings.update', $training), $updateData);

        $response->assertRedirect(route('admin.trainings.index'));

        $training->refresh();
        $this->assertNotNull($training->image);
        Storage::disk('public')->assertExists('trainings/'.$newImage->hashName());
        Storage::disk('public')->assertMissing('trainings/'.$oldImage->hashName());
    }

    public function test_can_update_training_with_multiple_images(): void
    {
        $oldImage1 = UploadedFile::fake()->image('old1.jpg');
        $oldImage2 = UploadedFile::fake()->image('old2.jpg');

        $training = Training::factory()->create([
            'images' => [
                'trainings/'.$oldImage1->hashName(),
                'trainings/'.$oldImage2->hashName(),
            ],
        ]);

        Storage::disk('public')->put('trainings/'.$oldImage1->hashName(), 'old content 1');
        Storage::disk('public')->put('trainings/'.$oldImage2->hashName(), 'old content 2');

        $newImage1 = UploadedFile::fake()->image('new1.jpg');
        $newImage2 = UploadedFile::fake()->image('new2.jpg');
        $newImage3 = UploadedFile::fake()->image('new3.jpg');

        $updateData = [
            'title' => $training->title,
            'description' => $training->description,
            'instructor' => $training->instructor,
            'start_date' => $training->start_date ? $training->start_date->format('Y-m-d') : null,
            'end_date' => $training->end_date ? $training->end_date->format('Y-m-d') : null,
            'location' => $training->location,
            'duration' => $training->duration,
            'capacity' => $training->capacity,
            'category' => $training->category,
            'is_active' => $training->is_active,
            'images' => [$newImage1, $newImage2, $newImage3],
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.trainings.update', $training), $updateData);

        $response->assertRedirect(route('admin.trainings.index'));

        $training->refresh();
        $this->assertNotNull($training->images);
        $this->assertCount(3, $training->images);
        Storage::disk('public')->assertExists('trainings/'.$newImage1->hashName());
        Storage::disk('public')->assertExists('trainings/'.$newImage2->hashName());
        Storage::disk('public')->assertExists('trainings/'.$newImage3->hashName());
        Storage::disk('public')->assertMissing('trainings/'.$oldImage1->hashName());
        Storage::disk('public')->assertMissing('trainings/'.$oldImage2->hashName());
    }

    public function test_can_delete_training_without_image(): void
    {
        $training = Training::factory()->create(['image' => null]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.trainings.destroy', $training));

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
    }

    public function test_can_delete_training_with_image(): void
    {
        $image = UploadedFile::fake()->image('training.jpg');
        $training = Training::factory()->create([
            'image' => 'trainings/'.$image->hashName(),
        ]);
        Storage::disk('public')->put('trainings/'.$image->hashName(), 'content');

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.trainings.destroy', $training));

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
        Storage::disk('public')->assertMissing('trainings/'.$image->hashName());
    }

    public function test_can_delete_training_with_multiple_images(): void
    {
        $image1 = UploadedFile::fake()->image('diamond1.jpg');
        $image2 = UploadedFile::fake()->image('diamond2.jpg');
        $image3 = UploadedFile::fake()->image('diamond3.jpg');

        $training = Training::factory()->create([
            'images' => [
                'trainings/'.$image1->hashName(),
                'trainings/'.$image2->hashName(),
                'trainings/'.$image3->hashName(),
            ],
        ]);

        Storage::disk('public')->put('trainings/'.$image1->hashName(), 'content 1');
        Storage::disk('public')->put('trainings/'.$image2->hashName(), 'content 2');
        Storage::disk('public')->put('trainings/'.$image3->hashName(), 'content 3');

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.trainings.destroy', $training));

        $response->assertRedirect(route('admin.trainings.index'));
        $this->assertDatabaseMissing('trainings', ['id' => $training->id]);
        Storage::disk('public')->assertMissing('trainings/'.$image1->hashName());
        Storage::disk('public')->assertMissing('trainings/'.$image2->hashName());
        Storage::disk('public')->assertMissing('trainings/'.$image3->hashName());
    }

    public function test_title_is_required(): void
    {
        $trainingData = [
            'title' => '',
            'description' => 'Test description',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-05',
            'category' => 'Technical',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.trainings.store'), $trainingData);

        $response->assertSessionHasErrors('title');
    }

    public function test_image_must_be_valid_format(): void
    {
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100);

        $trainingData = [
            'title' => 'Test Training',
            'description' => 'Test description',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-05',
            'category' => 'Technical',
            'image' => $invalidFile,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.trainings.store'), $trainingData);

        $response->assertSessionHasErrors('image');
    }
}
