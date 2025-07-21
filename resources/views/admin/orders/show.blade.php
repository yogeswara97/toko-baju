<x-admin.layout.layout :title="'Order Detail - ' . $order->order_code">
    <x-admin.layout.header :title="'Order: ' . $order->order_code" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('admin.dashboard')],
        ['label' => 'Orders', 'url' => route('admin.orders.index')],
        ['label' => $order->order_code],
    ]" />

    <div class="wrapper space-y-6">

        {{-- Order Info --}}
        <div class="bg-white p-6 rounded border border-gray-200 shadow-sm space-y-4">
            <h2 class="text-lg font-bold">Order Info</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Order Code:</strong> {{ $order->order_code }}</div>
                <div><strong>User:</strong> {{ $order->user->name ?? '-' }}</div>
                <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
                <div><strong>Total:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                <div><strong>Shipping Cost:</strong> Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
                <div><strong>Payment:</strong> {{ $order->payment_method ?? '-' }}</div>
                <div><strong>Created At:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="bg-white p-6 rounded border border-gray-200 shadow-sm space-y-2">
            <h2 class="text-lg font-bold">Shipping Address</h2>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
        </div>

        {{-- Order Items --}}
        <div class="bg-white p-6 rounded border border-gray-200 shadow-sm">
            <h2 class="text-lg font-bold mb-4">Order Items</h2>
            <table class="w-full text-sm border">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2">Product</th>
                        <th class="p-2">Variant</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->product_name }}</td>
                        <td class="p-2">{{ $item->variant_color ?? '-' }} / {{ $item->variant_size ?? '-' }}</td>
                        <td class="p-2">{{ $item->quantity }}</td>
                        <td class="p-2">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="p-2">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-admin.layout.layout>
