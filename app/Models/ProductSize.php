<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = ['name'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
