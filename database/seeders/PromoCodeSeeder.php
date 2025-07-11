<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PromoCode::create([
            'code' => 'DISKON10',
            'type' => 'percentage',
            'value' => 10,
            'max_uses' => 100,
            'max_uses_per_user' => 1,
            'expires_at' => Carbon::now()->addDays(30),
        ]);

        PromoCode::create([
            'code' => 'ONGKIRFREE',
            'type' => 'fixed',
            'value' => 50000,
            'max_uses' => null,
            'max_uses_per_user' => 1,
            'expires_at' => null,
        ]);

        PromoCode::create([
            'code' => 'LEBARAN20',
            'type' => 'percentage',
            'value' => 20,
            'max_uses' => 50,
            'max_uses_per_user' => 2,
            'expires_at' => Carbon::now()->addDays(7),
        ]);
    }
}
