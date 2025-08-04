<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('user_email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->user_email . '%');
            });
        }

        $orders = $query->paginate(10)->withQueryString();
        $userNames = User::pluck('name', 'id');

        return view('admin.orders.index', compact('orders', 'userNames'));
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
            'status' => 'nullable|in:pending,paid,shipped,completed,cancelled',
            'shipping_status' => 'nullable|in:requested,picked_up,in_transit,out_for_delivery,delivered,confirmed',
        ]);

        // Update status jika dikirim
        if ($request->filled('status')) {
            $order->status = $request->status;
        }

        // Update shipping status jika dikirim
        if ($request->filled('shipping_status')) {
            $order->shipping_status = $request->shipping_status;
        }

        $order->save();

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
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
