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
        'max_uses_per_user',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(PromoCodeUsage::class);
    }

    public function usageBy($userId)
    {
        return $this->usages()->where('user_id', $userId)->first();
    }

    public function isExpired()
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    public function remainingGlobalUses()
    {
        if (is_null($this->max_uses)) return null;

        $totalUsed = $this->usages()->sum('uses');
        return $this->max_uses - $totalUsed;
    }

    public function canBeUsedBy($userId)
    {
        if ($this->isExpired()) return false;

        $globalRemaining = $this->remainingGlobalUses();
        if (!is_null($globalRemaining) && $globalRemaining <= 0) return false;

        $userUsage = $this->usageBy($userId);
        if ($userUsage && $userUsage->uses >= $this->max_uses_per_user) {
            return false;
        }

        return true;
    }

    public function incrementUsageForUser($userId)
    {
        $usage = PromoCodeUsage::firstOrNew([
            'user_id' => $userId,
            'promo_code_id' => $this->id,
        ]);

        $usage->uses = ($usage->uses ?? 0) + 1;
        $usage->save();
    }
}
