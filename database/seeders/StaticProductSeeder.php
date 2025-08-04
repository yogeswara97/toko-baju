<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductColor;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaticProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeS = ProductSize::where('name', 'S')->first();
        $sizeM = ProductSize::where('name', 'M')->first();

        $colorBlack = ProductColor::where('name', 'Black')->first();
        $colorWhite = ProductColor::where('name', 'White')->first();
        $colorBrown = ProductColor::where('name', 'Brown')->first();

        // === PRODUCT 1: MEN SHIRT ===
        $productMen = Product::create([
            'category_id' => 1,
            'name' => 'Classic Men Shirt',
            'slug' => Str::slug('Classic Men Shirt'),
            'description' => 'Timeless shirt made for every occasion — casual or formal.',
            'price' => 250000,
            'image' => 'assets/static-images/category/man.png',
            'is_active' => true,
            'is_stock' => true,
        ]);

        foreach ([$sizeS, $sizeM] as $size) {
            foreach ([$colorBlack, $colorWhite, $colorBrown] as $color) {
                ProductVariant::create([
                    'product_id' => $productMen->id,
                    'product_size_id' => $size->id,
                    'product_color_id' => $color->id,
                    'qty' => 10,
                    'price' => 250000,
                    'image' => "assets/static-images/products/men/" . strtolower($color->name) . ".png",
                ]);
            }
        }

        // === PRODUCT 2: WOMEN BLOUSE ===
        $productWomen = Product::create([
            'category_id' => 2,
            'name' => 'Elegant Women Blouse',
            'slug' => Str::slug('Elegant Women Blouse'),
            'description' => 'Soft, stylish, and effortlessly chic for any moment.',
            'price' => 250000,
            'image' => 'assets/static-images/category/women.png',
            'is_active' => true,
            'is_stock' => true,
        ]);

        foreach ([$sizeS, $sizeM] as $size) {
            foreach ([$colorWhite, $colorBrown] as $color) {
                ProductVariant::create([
                    'product_id' => $productWomen->id,
                    'product_size_id' => $size->id,
                    'product_color_id' => $color->id,
                    'qty' => 10,
                    'price' => 250000,
                    'image' => "assets/static-images/products/women/" . strtolower($color->name) . ".png",
                ]);
            }
        }

        // === PRODUCT 3: ACCESSORIES ===
        $productAcc = Product::create([
            'category_id' => 3,
            'name' => 'Stylish Bag & Hat',
            'slug' => Str::slug('Stylish Bag & Hat'),
            'description' => 'Pair of minimalist bag and hat for that bold finishing touch.',
            'price' => 250000,
            'image' => 'assets/static-images/category/accessories.jpg',
            'is_active' => true,
            'is_stock' => true,
        ]);

        ProductVariant::create([
            'product_id' => $productAcc->id,
            'product_size_id' => null,
            'product_color_id' => null,
            'qty' => 20,
            'price' => 250000,
            'image' => 'assets/static-images/category/accessories.jpg',
        ]);
    }
}
