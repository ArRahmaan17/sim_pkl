<?php

namespace Database\Factories;

use App\Models\Cluster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'start_date' => fake()->date(),
            'deadline_date' => fake()->date(),
            'group' => json_encode([2, 3, 4]),
            'content' => fake()->text(1000),
            'thumbnail' => 'task-2023-12-11.png',
            'status' => 'Pending',
            'created_at' => now('Asia/Jakarta'),
            'updated_at' => now('Asia/Jakarta')
        ];
    }
}
