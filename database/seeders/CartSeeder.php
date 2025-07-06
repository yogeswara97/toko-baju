<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 3;

        $products = Product::with('variants')->inRandomOrder()->limit(3)->get();

        foreach ($products as $product) {
            $variant = $product->variants->random();

            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => rand(1, 3),
            ]);
        }
    }
}
