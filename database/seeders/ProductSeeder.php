<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = collect([
            ['name' => 'City Cruiser Stroller', 'category' => 'strollers', 'daily_rate' => 18.00, 'units' => 3],
            ['name' => 'Compact Travel Stroller', 'category' => 'strollers', 'daily_rate' => 16.00, 'units' => 2],
            ['name' => 'Travel Safe Car Seat', 'category' => 'car_seats', 'daily_rate' => 14.00, 'units' => 3],
            ['name' => 'Comfort Ride Infant Seat', 'category' => 'car_seats', 'daily_rate' => 12.00, 'units' => 2],
            ['name' => 'Dream Nest Crib', 'category' => 'cribs', 'daily_rate' => 17.00, 'units' => 3],
            ['name' => 'Foldaway Travel Crib', 'category' => 'cribs', 'daily_rate' => 13.50, 'units' => 2],
            ['name' => 'Easy Clean High Chair', 'category' => 'high_chairs', 'daily_rate' => 9.00, 'units' => 3],
            ['name' => 'Snap Fold High Chair', 'category' => 'high_chairs', 'daily_rate' => 8.50, 'units' => 2],
        ])->map(function (array $definition): Product {
            $color = fake()->randomElement(['orange', 'blue', 'green', 'red', 'purple', 'pink', 'teal']);
            $text = Str::of($definition['name'])->replace(' ', "\n");

            $product = Product::query()->create([
                'name' => $definition['name'],
                'slug' => Str::slug($definition['name']),
                'description' => fake()->paragraphs(2, true),
                'image_url' => "https://placehold.co/1200x900/{$color}/white?text={$text}",
                'daily_rate' => $definition['daily_rate'],
                'category' => $definition['category'],
                'is_active' => true,
            ]);

            foreach (range(1, $definition['units']) as $index) {
                ProductUnit::query()->create([
                    'product_id' => $product->getKey(),
                    'sku' => strtoupper(Str::substr($definition['category'], 0, 3)).'-'.str_pad((string) $index, 3, '0', STR_PAD_LEFT).'-'.$product->getKey(),
                    'condition' => fake()->randomElement(['excellent', 'good', 'fair']),
                    'is_available' => true,
                    'notes' => fake()->optional()->sentence(),
                ]);
            }

            return $product;
        });
    }
}
