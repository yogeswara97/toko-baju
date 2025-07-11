<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'is_active',
        'is_stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(ProductSize::class, 'product_variants')
                    ->distinct();
    }

    public function colors()
    {
        return $this->belongsToMany(ProductColor::class, 'product_variants')
                    ->distinct();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
