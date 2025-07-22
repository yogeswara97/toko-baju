<x-admin.layout.layout :title="'Order Detail - ' . $order->order_code">
    <x-admin.layout.header :title="'Order: ' . $order->order_code" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('admin.dashboard')],
        ['label' => 'Orders', 'url' => route('admin.orders.index')],
        ['label' => $order->order_code],
    ]" />

    <div class="space-y-6">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- KIRI --}}
            <div class="lg:w-1/3 space-y-6">

                {{-- Order Info --}}
                <div class="p-6 rounded-2xl border border-gray-100 bg-white shadow-sm space-y-5">
                    <h2 class="text-lg font-semibold text-gray-800 tracking-tight">Order Info</h2>

                    <div class="grid grid-cols-1 gap-3 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span class="font-medium">Order Code</span>
                            <span>{{ $order->order_code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">User</span>
                            <span>{{ $order->user->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Status</span>
                            <span class="capitalize">{{ $order->status }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Total</span>
                            <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Shipping Cost</span>
                            <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Payment</span>
                            <span>{{ $order->payment_method ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Created At</span>
                            <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>

                    @if ($order->status === 'pending')
                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full mt-4 px-4 py-2 bg-red-500 hover:bg-red-600 transition-all text-white text-sm font-medium rounded-xl shadow-sm">
                            Batalkan Order
                        </button>
                    </form>
                    @endif
                </div>

                {{-- Shipping Address --}}
                <div class="p-6 rounded-2xl border border-gray-100 bg-white shadow-sm space-y-3">
                    <h2 class="text-lg font-semibold text-gray-800">Shipping Address</h2>
                    <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $order->shipping_address }}
                    </p>
                </div>
            </div>

            {{-- KANAN --}}
            <div class="lg:w-2/3">
                <div class="p-6 rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 rounded-xl overflow-hidden">
                            <thead class="bg-gray-50 text-left text-gray-600">
                                <tr>
                                    <th class="p-4 border-b border-gray-200">Product</th>
                                    <th class="p-4 border-b border-gray-200">Variant</th>
                                    <th class="p-4 border-b border-gray-200">Qty</th>
                                    <th class="p-4 border-b border-gray-200">Price</th>
                                    <th class="p-4 border-b border-gray-200">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $grandTotal = 0; @endphp
                                @foreach ($order->items as $item)
                                @php $grandTotal += $item->subtotal; @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 flex items-center gap-3">
                                        @if ($item->product_image)
                                        <img src="{{ asset('storage/images/' . $item->product_image) }}"
                                            alt="Product Image"
                                            class="w-10 h-10 object-cover rounded-lg border border-gray-200">
                                        @endif
                                        <span class="text-gray-800">{{ $item->product_name }}</span>
                                    </td>
                                    <td class="p-4 text-gray-700">{{ $item->variant_color ?? '-' }} / {{
                                        $item->variant_size ?? '-' }}</td>
                                    <td class="p-4 text-gray-700">{{ $item->quantity }}</td>
                                    <td class="p-4 text-gray-700">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="p-4 text-gray-700">Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4"
                                        class="text-right font-semibold p-4 border-t border-gray-200 text-gray-700">
                                        Total</td>
                                    <td class="p-4 border-t border-gray-200 font-bold text-green-700">
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
