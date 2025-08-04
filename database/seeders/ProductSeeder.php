<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ukuran dan warna tertentu secara berurutan
        $selectedSizes = ProductSize::whereIn('name', ['S', 'M'])->get(); // Tetap
        $selectedColors = ProductColor::whereIn('name', ['Black', 'White'])->get(); // Tetap

        $products = [
            [
                'name' => 'Classic Men Shirt',
                'category_id' => 1,
                'image' => 'assets/static-images/category/man.png',
                'has_variant' => true,
                'description' => 'Timeless shirt made for every occasion — casual or formal.',
            ],
            [
                'name' => 'Elegant Women Blouse',
                'category_id' => 2,
                'image' => 'assets/static-images/category/women.png',
                'has_variant' => true,
                'description' => 'Soft, stylish, and effortlessly chic for any moment.',
            ],
            [
                'name' => 'Stylish Bag & Hat',
                'category_id' => 3,
                'image' => 'assets/static-images/category/accessories.jpg',
                'has_variant' => false,
                'description' => 'Pair of minimalist bag and hat for that bold finishing touch.',
            ],
        ];

        foreach ($products as $item) {
            $product = Product::create([
                'category_id' => $item['category_id'],
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'price' => 250000,
                'qty' => 0,
                'image' => $item['image'],
                'is_active' => true,
                'is_stock' => true,
            ]);

            if (!$item['has_variant']) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'product_size_id' => null,
                    'product_color_id' => null,
                    'qty' => 20,
                    'price' => 250000,
                ]);
                $product->update(['qty' => 20]);
                continue;
            }

            $totalQty = 0;

            // Kombinasi tetap: 2 sizes x 2 colors = 4 variants
            foreach ($selectedSizes as $size) {
                foreach ($selectedColors as $color) {
                    $qty = 10;
                    $variantPrice = 250000;

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'product_size_id' => $size->id,
                        'product_color_id' => $color->id,
                        'qty' => $qty,
                        'price' => $variantPrice,
                    ]);

                    $totalQty += $qty;
                }
            }

            $product->update(['qty' => $totalQty]);
        }
    }

}
