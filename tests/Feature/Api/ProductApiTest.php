<?php

use App\Models\Product;
use App\Models\ProductUnit;

test('products index returns active products and supports category filtering', function () {
    $stroller = Product::factory()->create([
        'name' => 'City Cruiser Stroller',
        'slug' => 'city-cruiser-stroller',
        'category' => 'strollers',
        'is_active' => true,
    ]);
    ProductUnit::factory()->count(2)->for($stroller)->create();

    $crib = Product::factory()->create([
        'name' => 'Dream Nest Crib',
        'slug' => 'dream-nest-crib',
        'category' => 'cribs',
        'is_active' => true,
    ]);
    ProductUnit::factory()->count(3)->for($crib)->create();

    Product::factory()->create([
        'name' => 'Hidden Product',
        'slug' => 'hidden-product',
        'category' => 'strollers',
        'is_active' => false,
    ]);

    $this->getJson('/api/products?category=strollers')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'city-cruiser-stroller')
        ->assertJsonPath('data.0.units_count', 2);
});

test('products can be shown by slug', function () {
    $product = Product::factory()->create([
        'name' => 'Travel Safe Car Seat',
        'slug' => 'travel-safe-car-seat',
        'category' => 'car_seats',
        'daily_rate' => 14.00,
    ]);
    ProductUnit::factory()->count(2)->for($product)->create();

    $this->getJson('/api/products/travel-safe-car-seat')
        ->assertSuccessful()
        ->assertJsonPath('data.slug', 'travel-safe-car-seat')
        ->assertJsonPath('data.daily_rate', 14)
        ->assertJsonPath('data.units_count', 2);
});
