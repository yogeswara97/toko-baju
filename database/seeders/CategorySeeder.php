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
        $categories = [
            [
                'name' => 'Men',
                'title' => 'MEN’S ESSENTIALS: SHIRTS, TEES & POLOS',
                'slug' => 'men',
                'image' => 'assets/static-images/category/man.png',
                'description' => 'Upgrade your wardrobe with timeless pieces for every occasion. From sleek polos to comfy tees — find your fit and stay effortlessly cool, all day every day.',
            ],
            [
                'name' => 'Women',
                'title' => 'FOR HER: BLOUSES, TOPS & CHIC TEES',
                'slug' => 'women',
                'image' => 'assets/static-images/category/women.png',
                'description' => 'Style made simple. Dive into our curated picks of modern blouses, everyday tops, and trend-forward tees that fit every mood — from classy to casual.',
            ],
            [
                'name' => 'Accessories',
                'title' => 'BAGS, HATS & ALL THE EXTRAS',
                'slug' => 'accessories',
                'image' => 'assets/static-images/category/accessories.jpg',
                'description' => 'Top off your look with must-have accessories. From statement bags to everyday hats — it’s the little things that make the biggest style impact.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'title' => $cat['title'],
                'slug' => $cat['slug'],
                'image' => $cat['image'],
                'description' => $cat['description'],
                'is_display' => true,
            ]);
        }
    }
}
