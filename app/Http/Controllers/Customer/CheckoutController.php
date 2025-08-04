<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\PromoCode;
use App\Models\PromoCodeUsage;
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
        $user = Auth::user();

        // Cek pesanan pending
        $hasPendingOrder = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingOrder) {
            return back()->with('error', 'Kamu masih punya pesanan yang belum selesai.');
        }

        // Validasi input minimal
        $request->validate([
            'raja_ongkir_id' => 'required|integer',
            'shipping_address' => 'required|string',
            'shipping_cost' => 'required|integer|min:0',
        ]);

        // Ambil ulang cart dari DB
        $cartItems = Cart::with(['product', 'variant.color', 'variant.size'])
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kamu kosong.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->variant->price * $item->quantity);

        $shippingCost = $request->shipping_cost;
        $discount = 0;
        $promo = session('promo');

        if ($promo) {
            $discount = $promo['type'] === 'percentage'
                ? $subtotal * ($promo['value'] / 100)
                : $promo['value'];
        }

        $total = $subtotal - $discount + $shippingCost;

        // Buat Order
        $orderCode = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => $orderCode,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total_amount' => $total,
            'status' => 'pending',
            'raja_ongkir_id' => $request->raja_ongkir_id,
            'shipping_cost' => $shippingCost,
            'shipping_address' => $request->shipping_address,
            'payment_method' => 'midtrans',
        ]);

        // Simpan Order Items dan kurangi stok
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'product_variant_id' => $item->variant->id,
                'product_name' => $item->product->name,
                'variant_color' => $item->variant->color->name ?? null,
                'variant_size' => $item->variant->size->name ?? null,
                'price' => $item->variant->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->variant->price * $item->quantity,
            ]);

            $item->variant->decrement('qty', $item->quantity);
        }

        // Promo
        if ($promo) {
            PromoCode::find($promo['id'])?->incrementUsageForUser($user->id);
            session()->forget('promo');
        }

        // Hapus cart
        Cart::where('user_id', $user->id)->delete();

        // Midtrans
        $midtrans = new MidtransService();
        $snapToken = $midtrans->createTransaction($order, $user);

        Payment::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'gross_amount' => $total,
            'transaction_status' => 'pending',
            'snap_token' => $snapToken,
        ]);

        return view('customer.orders.payment', compact('snapToken', 'order'));
    }



    public function status($status, $order_code, Request $request)
    {

        if ($request->query('closed')) {
            session()->flash('warning', 'Kamu menutup pembayaran sebelum selesai 😢');
        }
        $status = strtolower($status);

        $snapToken = $request->query('snap_token');

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
            'snapToken'
        ]);
    }
}
