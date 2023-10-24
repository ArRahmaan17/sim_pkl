<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ID')->firstName(),
            'icon' => 'fas fa-home',
            'link' => route('home'),
            'parent' => 0,
            'position' => 'S',
            'ordered' => null,
            'access_to' => 'All',
            'created_at' => now('Asia/Jakarta'),
            'updated_at' => null,
        ];
    }
}
