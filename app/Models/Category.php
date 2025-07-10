<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'title',
        'slug',
        'image',
        'description',
        'is_display',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
