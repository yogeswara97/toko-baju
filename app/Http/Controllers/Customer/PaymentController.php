<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $orderCode = $request->order_code;
        $snapToken = $request->snapToken;

        $order = Order::with('items') // atau relasi yang kamu perlukan
            ->where('order_code', $orderCode)
            ->where('user_id', Auth::id()) // biar lebih aman
            ->firstOrFail();

        return view('customer.orders.payment', [
            'snapToken' => $snapToken,
            'order' => $order,
        ]);
    }
}
