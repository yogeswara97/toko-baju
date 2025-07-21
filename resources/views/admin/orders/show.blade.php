<x-admin.layout.layout :title="'Order Detail - ' . $order->order_code">
    <x-admin.layout.header :title="'Order: ' . $order->order_code" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('admin.dashboard')],
        ['label' => 'Orders', 'url' => route('admin.orders.index')],
        ['label' => $order->order_code],
    ]" />

    <div class="space-y-6">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- KIRI: Order Info + Cancel + Address --}}
            <div class="lg:w-1/3 space-y-6">
                {{-- Order Info --}}
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm space-y-3">
                    <h2 class="text-base font-semibold">Order Info</h2>
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        <div><strong>Order Code:</strong> {{ $order->order_code }}</div>
                        <div><strong>User:</strong> {{ $order->user->name ?? '-' }}</div>
                        <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
                        <div><strong>Total:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                        <div><strong>Shipping Cost:</strong> Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                        </div>
                        <div><strong>Payment:</strong> {{ $order->payment_method ?? '-' }}</div>
                        <div><strong>Created At:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>

                    {{-- Cancel Button --}}
                    @if ($order->status === 'pending')
                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full mt-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg">
                            Batalkan Order
                        </button>
                    </form>
                    @endif
                </div>

                {{-- Shipping Address --}}
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-base font-semibold mb-1">Shipping Address</h2>
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>
            </div>

            {{-- KANAN: Order Items --}}
            <div class="lg:w-2/3">
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-base font-semibold mb-3">Order Items</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200">
                            <thead class="bg-gray-50 text-left">
                                <tr class="text-gray-700">
                                    <th class="p-3 border-b border-gray-200">Product</th>
                                    <th class="p-3 border-b border-gray-200">Variant</th>
                                    <th class="p-3 border-b border-gray-200">Qty</th>
                                    <th class="p-3 border-b border-gray-200">Price</th>
                                    <th class="p-3 border-b border-gray-200">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php $grandTotal = 0; @endphp
                                @foreach ($order->items as $item)
                                @php $grandTotal += $item->subtotal; @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 flex items-center gap-3">
                                        @if ($item->product_image)
                                        <img src="{{ asset('storage/images/' . $item->product_image) }}"
                                            alt="Product Image"
                                            class="w-10 h-10 object-cover rounded-lg border border-gray-200">
                                        @endif
                                        {{ $item->product_name }}
                                    </td>
                                    <td class="p-3">{{ $item->variant_color ?? '-' }} / {{ $item->variant_size ?? '-' }}
                                    </td>
                                    <td class="p-3">{{ $item->quantity }}</td>
                                    <td class="p-3">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="p-3">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="text-right font-semibold p-3 border-t border-gray-200">Total
                                    </td>
                                    <td class="text-left font-bold p-3 border-t border-gray-200 text-green-700">
                                        Rp{{ number_format($grandTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layout.layout>
