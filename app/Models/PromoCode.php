<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromoCode extends Model
{
     protected $fillable = [
        'code',
        'type',
        'value',
        'max_uses',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(PromoCodeUsage::class);
    }
}
