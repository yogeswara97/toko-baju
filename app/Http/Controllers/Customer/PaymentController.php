<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $orderCode = $request->order_code;
        $snapToken = $request->snapToken;

        $order = Order::with('items')
            ->where('order_code', $orderCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$snapToken) {
            $snapToken = Payment::where('order_code', $orderCode)->value('snap_token');
        }

        if (!$snapToken) {
            return redirect()->route('customer.profile.index')
                ->with('error', 'Token pembayaran tidak ditemukan.');
        }

        return view('customer.orders.payment', [
            'snapToken' => $snapToken,
            'order' => $order,
        ]);
    }


    public function cancel(Request $request)
    {
        $orderCode = $request->query('order_code'); // pakai query karena kita redirect, bukan JSON

        $order = Order::where('order_code', $orderCode)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('customer.checkout.status', [
                'status' => 'failed',
                'order_code' => $orderCode,
            ])->with('error', 'Order tidak ditemukan.');
        }

        // Kalau sudah cancel/success, langsung redirect juga
        if (in_array($order->status, ['cancelled', 'success'])) {
            return redirect()->route('customer.checkout.status', [
                'status' => 'failed',
                'order_code' => $orderCode,
            ])->with('warning', 'Order tidak bisa di-cancel.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('customer.checkout.status', [
            'status' => 'failed',
            'order_code' => $orderCode,
        ])->with('success', 'Order dibatalkan.');
    }
}
