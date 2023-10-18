<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake('ID')->firstName(),
            'last_name' => fake('ID')->lastName(),
            'email' => fake('ID')->unique()->safeEmail(),
            'student_identification_number' => fake()->unique()->randomNumber(),
            'username' => fake('ID')->userName(),
            'password' => Hash::make('password'),
            'phone_number' => fake('ID')->phoneNumber(),
            'address' => fake('ID')->address(),
            'profile_picture' => fake('ID')->randomElement([
                'assets/img/avatar/avatar-1.png',
                'assets/img/avatar/avatar-2.png',
                'assets/img/avatar/avatar-3.png',
                'assets/img/avatar/avatar-4.png'
            ]),
            'gender' => 'M',
            'role' => 'M',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
