<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = ['name', 'hex_code'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
