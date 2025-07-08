<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        // $tax = round($subtotal * 0.1); // 10%
        $shippingCost = 999;
        $promo = session('promo');
        $discount = 0;

        if ($promo) {
            $discount = $promo['type'] === 'percentage'
                ? $subtotal * ($promo['value'] / 100)
                : $promo['value'];
        }

        // $total = $subtotal - $discount + $shippingCost + $tax;
        $total = $subtotal - $discount + $shippingCost;



        return view('customer.orders.checkout', compact(
            'cartItems',
            'subtotal',
            // 'tax',
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

    public function order(Request $request)
    {
        $data = $request->validate([
            'total' => 'required|numeric|min:0',
            'raja_ongkir_id' => 'required|integer',
            'shipping_cost' => 'required|integer|min:1',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.product_variant_id' => 'required|integer|exists:product_variants,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.variant_color' => 'nullable|string|max:50',
            'items.*.variant_size' => 'nullable|string|max:50',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.subtotal' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // Generate kode order
        $orderCode = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => $orderCode,
            'total_amount' => $request->total,
            'status' => 'paid',
            'raja_ongkir_id' => $request->raja_ongkir_id,
            'shipping_cost' => $request->shipping_cost,
            'shipping_address' => $request->shipping_address,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'payment_method' => 'midtrans',
        ]);

        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'],
                'product_name' => $item['product_name'],
                'variant_color' => $item['variant_color'] ?? null,
                'variant_size' => $item['variant_size'] ?? null,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // (Opsional) hapus cart user setelah order sukses
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('customer.profile')->with('success', 'Order berhasil dibuat!');
    }

    public function payment()
    {
        return view('customer.orders.payment');
    }
}
