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
            'value' => 10, // 10%
            'max_uses' => 100,
            'expires_at' => Carbon::now()->addDays(30),
        ]);

        PromoCode::create([
            'code' => 'ONGKIRFREE',
            'type' => 'fixed',
            'value' => 9.99, // potongan tetap
            'max_uses' => null,
            'expires_at' => null,
        ]);

        PromoCode::create([
            'code' => 'LEBARAN20',
            'type' => 'percentage',
            'value' => 20,
            'max_uses' => 50,
            'expires_at' => Carbon::now()->addDays(7),
        ]);
    }
}
