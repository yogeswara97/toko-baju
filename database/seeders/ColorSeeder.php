<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Gray', 'hex_code' => '#808080'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
