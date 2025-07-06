<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = Size::all();   // ambil data dari tabel sizes
        $colors = Color::all(); // ambil data dari tabel colors

        for ($i = 1; $i <= 10; $i++) {
            $categoryId = rand(1, 3);
            $basePrice = rand(100, 500) * 1000;

            $imageUrl = "https://picsum.photos/id/" . rand(1, 100) . "/400/400";

            $name = 'Product ' . $i;

            // Buat produk
            $product = Product::create([
                'category_id' => $categoryId,
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Deskripsi singkat untuk produk ' . $i,
                'price' => $basePrice,
                'qty' => 0,
                'image' => $imageUrl,
                'is_active' => true,
                'is_stock' => true,
            ]);

            // Jika kategori aksesoris (misal: ID = 3), gak punya varian
            if ($categoryId == 3) {
                $product->update(['qty' => rand(10, 50)]);
                continue;
            }

            // Produk dengan varian
            $totalQty = 0;

            // Kombinasi acak dari size & color (ambil max 3-4 kombinasi)
            $combinations = $sizes->crossJoin($colors)->shuffle()->take(rand(3, 4));

            foreach ($combinations as [$size, $color]) {
                $qty = rand(5, 20);
                $variantPrice = $basePrice + (rand(0, 3) * 10000);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                    'color_id' => $color->id,
                    'qty' => $qty,
                    'price' => $variantPrice,
                ]);

                $totalQty += $qty;
            }

            $product->update(['qty' => $totalQty]);
        }
    }
}

