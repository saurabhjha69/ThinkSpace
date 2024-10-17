<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'views' => fake()->numberBetween(0, 1000),
            'duration' => fake()->numberBetween(1, 100),
            'watch_hrs' => fake()->numberBetween(1, 1000),
            'public_id' => fake()->uuid(),
            'type' => fake()->randomElement(['mp4', 'mov' ,'avi','mkv', 'webm']),
        ];
    }
}
