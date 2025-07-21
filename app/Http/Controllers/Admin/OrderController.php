<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items']);
        return view('admin.orders.show', compact('order'));
    }

    public function create()
    {
        abort(404); // biasanya order dibuat dari frontend, bukan admin
    }

    public function store(Request $request)
    {
        abort(404); // sama juga, store ga dipake di admin
    }

    public function edit(Order $order)
    {
        // Optional: edit status order, misalnya
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted.');
    }

    public function cancel(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Order hanya bisa dibatalkan saat status masih pending.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order berhasil dibatalkan.');
    }
}
