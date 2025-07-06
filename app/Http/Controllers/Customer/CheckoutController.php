<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::with(['product', 'variant.size', 'variant.color'])
            ->where('user_id', $user->id)
            ->get();

        $addresses = $user->addresses;

        $addressId = session('default_address');
        $defaultAddress = $addresses->firstWhere('id', $addressId) ?? $addresses->firstWhere('is_default', true);

        $subtotal = $cartItems->sum(fn($item) => $item->variant->price * $item->quantity);
        $tax = round($subtotal * 0.1); // 10%
        $shippingCost = 999;
        $promo = session('promo');
        $discount = 0;

        if ($promo) {
            $discount = $promo['type'] === 'percentage'
                ? $subtotal * ($promo['value'] / 100)
                : $promo['value'];
        }

        $total = $subtotal - $discount + $shippingCost + $tax;



        return view('customer.orders.checkout', compact(
            'cartItems',
            'subtotal',
            'tax',
            'discount',
            'total',
            'shippingCost',
            'promo',
            'addresses',
            'defaultAddress'
        ));
    }

    public function setAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        session(['default_address' => $request->address_id]);

        return redirect()->route('customer.checkout.index');
    }
}
