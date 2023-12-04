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
            'first_name' => fake('id_ID')->firstName(),
            'last_name' => fake('id_ID')->lastName(),
            'email' => fake('id_ID')->unique()->safeEmail(),
            'student_identification_number' => fake()->unique()->randomNumber(),
            'username' => fake('id_ID')->userName(),
            'password' => Hash::make('password'),
            'phone_number' => fake('id_ID')->phoneNumber(),
            'address' => fake('id_ID')->address(),
            'profile_picture' => fake('id_ID')->randomElement([
                'img/avatar/avatar-1.png',
                'img/avatar/avatar-2.png',
                'img/avatar/avatar-3.png',
                'img/avatar/avatar-4.png'
            ]),
            'gender' => 'M',
            'role' => 'S',
        ];
    }
}
