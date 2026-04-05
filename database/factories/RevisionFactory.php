<?php

namespace Database\Factories;

use App\Models\Revision;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Revision>
 */
class RevisionFactory extends Factory
{
    protected $model = Revision::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = ['created', 'updated', 'deleted', 'published', 'unpublished', 'restored'];

        return [
            'user_id' => User::factory(),
            'revisionable_type' => 'App\\Models\\Page',
            'revisionable_id' => $this->faker->numberBetween(1, 100),
            'action' => $this->faker->randomElement($actions),
            'old_values' => json_encode(['title' => $this->faker->sentence()]),
            'new_values' => json_encode(['title' => $this->faker->sentence()]),
        ];
    }
}
