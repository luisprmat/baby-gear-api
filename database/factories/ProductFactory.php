<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $color = fake()->randomElement(['orange', 'blue', 'green', 'red', 'purple', 'pink', 'teal']);
        $text = Str::of($name)->title()->replace(' ', "\n");

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(2, true),
            'image_url' => "https://placehold.co/1200x900/{$color}/white?text={$text}",
            'daily_rate' => fake()->randomFloat(2, 8, 20),
            'category' => fake()->randomElement(['strollers', 'car_seats', 'cribs', 'high_chairs']),
            'is_active' => true,
        ];
    }
}
