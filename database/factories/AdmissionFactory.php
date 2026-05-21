<?php

namespace Database\Factories;

use App\Models\Admission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Admission>
 */
class AdmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $governorates = ['Cairo', 'Alexandria', 'Giza', 'Aswan', 'Luxor', 'Port Said'];
        
        return [
            'user_id' => User::factory(),
            'national_id' => '3' . fake()->numerify('############'), // 14 digits starting with 3
            'first_name' => fake()->firstName(),
            'second_name' => fake()->firstName(),
            'third_name' => fake()->firstName(),
            'fourth_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_governorate' => fake()->randomElement($governorates),
            'current_governorate' => fake()->randomElement($governorates),
            'city_center' => fake()->city(),
            'village_district' => fake()->streetName(),
            'street_address' => fake()->address(),
            'religion' => fake()->randomElement(['Muslim', 'Christian']),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'phone' => '01' . fake()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
            'student_photo' => 'photos/' . fake()->uuid() . '.jpg',
            'birth_certificate' => 'certificates/' . fake()->uuid() . '.pdf',
            'qualification_certificate' => 'certificates/' . fake()->uuid() . '.pdf',
            'student_id_document' => 'documents/' . fake()->uuid() . '.pdf',
            'parent_name' => fake()->name(),
            'parent_phone' => '01' . fake()->numerify('#########'),
            'father_occupation' => fake()->jobTitle(),
            'parent_id_document' => 'documents/' . fake()->uuid() . '.pdf',
            'status' => 'pending',
            'student_code' => null,
            'rejection_reason' => null,
            'reviewed_at' => null,
            'reviewed_by' => null,
        ];
    }

    /**
     * Indicate that the admission is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'student_code' => null,
            'reviewed_at' => null,
            'reviewed_by' => null,
        ]);
    }

    /**
     * Indicate that the admission is accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
            'student_code' => now()->year . str_pad(fake()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'reviewed_at' => now(),
            'reviewed_by' => User::factory(),
        ]);
    }

    /**
     * Indicate that the admission is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'rejection_reason' => fake()->sentence(),
            'reviewed_at' => now(),
            'reviewed_by' => User::factory(),
        ]);
    }
}
