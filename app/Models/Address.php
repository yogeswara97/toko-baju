<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'raja_ongkir_id',
        'name',
        'address_line1',
        'address_line2',
        'subdistrict_name',
        'district_name',
        'city_name',
        'province_name',
        'zip_code',
        'is_default',
    ];

    /**
     * Address belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
