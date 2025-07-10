<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
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

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang kamu kosong, yuk belanja dulu!');
        }

        $addresses = $user->addresses;

        $addressId = session('default_address');
        $defaultAddress = $addresses->firstWhere('id', $addressId) ?? $addresses->firstWhere('is_default', true);

        $subtotal = $cartItems->sum(fn($item) => $item->variant->price * $item->quantity);
        $shippingCost = session('shipping_cost', 0);

        $promo = session('promo');
        $discount = 0;

        if ($promo) {
            $discount = $promo['type'] === 'percentage'
                ? $subtotal * ($promo['value'] / 100)
                : $promo['value'];
        }

        $total = $subtotal - $discount + $shippingCost;

        return view('customer.orders.checkout', compact(
            'cartItems',
            'subtotal',
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
        $request->validate([
            'total' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'raja_ongkir_id' => 'required|integer',
            'shipping_cost' => 'required|integer|min:0',
            'shipping_address' => 'required|string',
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

        $orderCode = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => $orderCode,
            'subtotal' => (int) $request->subtotal,
            'discount' => (int) $request->discount,
            'total_amount' => (int) $request->total,
            'status' => 'pending',
            'raja_ongkir_id' => $request->raja_ongkir_id,
            'shipping_cost' => (int) $request->shipping_cost,
            'shipping_address' => $request->shipping_address,
            'payment_method' => 'midtrans',
        ]);

        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['product_variant_id'],
                'product_name' => $item['product_name'],
                'variant_color' => $item['variant_color'] ?? null,
                'variant_size' => $item['variant_size'] ?? null,
                'price' => (int) $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => (int) $item['subtotal'],
            ]);
        }


        Cart::where('user_id', $user->id)->delete();

        // Generate Snap Token
        $midtrans = new MidtransService();
        $snapToken = $midtrans->createTransaction($order, $user);

        // Save to payments table
        Payment::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'gross_amount' => (int) $order->total_amount,
            'transaction_status' => 'pending',
            'snap_token' => $snapToken,
        ]);

        return view('customer.orders.payment', [
            'snapToken' => $snapToken,
            'order' => $order,
        ]);
    }

    public function status($status, $order_code)
    {
        $status = strtolower($status);

        if (!in_array($status, ['success', 'pending', 'failed'])) {
            abort(404);
        }

        $order = Order::where('order_code', $order_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update([
            'status' => $status === 'success' ? 'paid' : 'pending',
        ]);

        return view('customer.orders.status', [
            'status' => $status,
            'orderCode' => $order->order_code,
        ]);
    }
}
