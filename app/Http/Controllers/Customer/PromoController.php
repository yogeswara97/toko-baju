<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\PromoCodeUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return back()->with('promo.error', 'Kamu harus login untuk menggunakan promo.');
        }

        // Cari promo yang valid dan belum expired
        $promo = PromoCode::where('code', $request->promo_code)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$promo) {
            return back()->with('promo.error', 'Promo code tidak valid atau sudah kedaluwarsa.');
        }

        // Ambil pemakaian promo oleh user ini
        $usage = PromoCodeUsage::where('user_id', $user->id)
            ->where('promo_code_id', $promo->id)
            ->first();

        $maxUses = $promo->max_uses_per_user ?? 1;

        if ($usage && $usage->uses >= $maxUses) {
            return back()->with('promo.error', 'Promo code ini sudah kamu gunakan sebanyak maksimal (' . $maxUses . ') kali.');
        }

        // Simpan promo ke session
        session(['promo' => $promo->toArray()]);

        return back()->with('promo.success', 'Promo code berhasil diterapkan!');
    }



    public function remove()
    {
        session()->forget('promo');

        return back()->with('promo.success', 'Promo code dihapus.');
    }
}
