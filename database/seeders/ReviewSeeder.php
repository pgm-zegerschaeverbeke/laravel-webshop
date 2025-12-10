<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure products exist; then attach a few reviews per product.
        Product::query()
            ->select('id')
            ->get()
            ->each(function (Product $product): void {
                Review::factory()
                    ->count(fake()->numberBetween(2, 6))
                    ->state([
                        'product_id' => $product->id,
                    ])
                    ->create();
            });
    }
}


