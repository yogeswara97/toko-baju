<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($order_code)
    {
        $order = Order::with(['items.product', 'payment'])
            ->where('order_code', $order_code)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $snapToken = null;
        if ($order->status === 'pending') {
            $snapToken = $order->payment->snap_token;
        }
        return view('customer.profile.orders', compact('order', 'snapToken'));
    }
    public function confirmShipping(Order $order)
{
    // Cek status sekarang harus sudah delivered dulu
    if ($order->shipping_status !== 'delivered') {
        return back()->with('error', 'Pengiriman belum selesai. Tidak bisa dikonfirmasi.');
    }

    $order->shipping_status = 'confirmed';
    $order->save();

    return back()->with('success', 'Pesanan berhasil dikonfirmasi diterima.');
}
}
