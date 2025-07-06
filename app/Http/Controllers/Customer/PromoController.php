<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
        ]);

        $promo = PromoCode::where('code', $request->promo_code)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$promo) {
            return back()->with('promo.error', 'Promo code tidak valid atau sudah kedaluwarsa.');
        }

        session(['promo' => $promo->toArray()]);

        return back()->with('promo.success', 'Promo code berhasil diterapkan!');
    }

    public function remove()
    {
        session()->forget('promo');

        return back()->with('promo.success', 'Promo code dihapus.');
    }
}
