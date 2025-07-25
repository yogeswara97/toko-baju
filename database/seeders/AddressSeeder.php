<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $now = Carbon::now();

        foreach ($users as $user) {
            DB::table('addresses')->insert([
                [
                    'user_id' => $user->id,
                    'raja_ongkir_id' => 26027,
                    'name' => 'Rumah',
                    'address_line1' => 'Jl. Mawar No. 123',
                    'address_line2' => 'RT 04 RW 02',
                    'subdistrict_name' => 'DAUH PURI',
                    'district_name' => 'DENPASAR BARAT',
                    'city_name' => 'DENPASAR',
                    'province_name' => 'BALI',
                    'zip_code' => '80113',
                    'is_default' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'user_id' => $user->id,
                    'raja_ongkir_id' => 26028,
                    'name' => 'Tempat Kerja',
                    'address_line1' => 'Jl. Melati No. 456',
                    'address_line2' => null,
                    'subdistrict_name' => 'DAUH PURI KANGIN',
                    'district_name' => 'DENPASAR BARAT',
                    'city_name' => 'DENPASAR',
                    'province_name' => 'BALI',
                    'zip_code' => '80112',
                    'is_default' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }
}
