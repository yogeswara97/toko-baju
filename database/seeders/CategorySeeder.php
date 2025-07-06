<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Men',
                'slug' => 'men',
                'description' => 'Fashion pria keren, dari kasual sampe formal.',
                'image' => 'assets/images/categories/men.jpg',
            ],
            [
                'name' => 'Women',
                'slug' => 'women',
                'description' => 'Gaya stylish untuk para wanita kece.',
                'image' => 'assets/images/categories/women.jpg',
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Lengkapi outfit loe dengan aksesoris kece.',
                'image' => 'assets/images/categories/accessories.jpg',
            ],
        ]);
    }
}
