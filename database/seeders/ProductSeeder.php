<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Food', 'Beverages', 'Household', 'Personal Care', 'Electronics'];
        $statuses = ['active', 'inactive'];

        // Create 20 sample products
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 1, 1000),
                'stock' => fake()->numberBetween(0, 100),
                'category' => fake()->randomElement($categories),
                'status' => fake()->randomElement($statuses),
                'created_by' => 1, // Assuming user ID 1 exists
                'updated_by' => 1,
            ]);
        }
    }
} 