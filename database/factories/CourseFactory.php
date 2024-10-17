<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3), // Course name
            'description' => fake()->paragraph(2), // Description of the course
            'about' => fake()->text(200), // About the course
            'duration' => fake()->numberBetween(1, 100), // Random duration in hours
            'language' => fake()->randomElement(['English', 'Spanish', 'French', 'German']), // Random language
            'status' => fake()->randomElement(['active', 'inactive', 'deleted']), // Random course status
            'is_free' => fake()->boolean(), // Whether the course is free or not
            'difficulty' => fake()->randomElement(['easy', 'intermediate', 'advanced']), // Random difficulty
            'max_students' => fake()->numberBetween(10, 1000), // Random max students
            'price' => fake()->numberBetween(100, 10000), // Random price
            'est_price' => fake()->numberBetween(50, 9000), // Random estimated price
            'category_id' => Category::factory(), // Use category factory or a random category ID
            'user_id' => User::factory(), // Use user factory or a random user ID
            'thumbnail_url' => fake()->imageUrl(640, 480, 'course'), // Random thumbnail URL
            'video_id' => Video::factory()->create()->id ?? null, // Use video factory if needed, // Use certificate factory if needed
        ];
    }
}
