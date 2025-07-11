<x-customer.layout.layout>
    <section class="container-custom">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Order Header -->
            <div class="rounded-lg border border-gray-200 p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_code }}</h1>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        @php
                        $statusColors = getStatusColors();
                        @endphp

                        <span
                            class="{{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }} px-3 py-1 rounded-full text-sm font-semibold">
                            {{ ucfirst($order->status) }}
                        </span>

                        <p class="text-2xl font-bold text-gray-900 mt-2">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Order Progress -->
                @php
                $steps = ['Order Placed', 'Processing', 'Shipped', 'Delivered'];
                $activeIndex = array_search(ucfirst($order->status), $steps);
                @endphp
                <div class="flex items-center justify-between mt-6">
                    @foreach ($steps as $index => $step)
                    <div class="flex items-center">
                        <div
                            class="w-8 h-8 {{ $index <= $activeIndex ? 'bg-green-500' : 'bg-gray-300' }} text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span
                            class="ml-2 text-sm font-medium {{ $index <= $activeIndex ? 'text-green-600' : 'text-gray-400' }}">{{
                            $step }}</span>
                    </div>
                    @if (!$loop->last)
                    <div class="flex-1 h-1 {{ $index < $activeIndex ? 'bg-green-500' : 'bg-gray-300' }} mx-4">
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="rounded-lg border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold mb-4">Order Items</h2>

                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                            <div class="flex items-center border-b border-gray-200 pb-4">

                                <img src="{{ $item->product->image ? asset($item->product->image) : asset('assets/static-images/no-image.jpg') }}"
                                    alt="{{ $item->product->name }}"
                                    class="w-20 h-28 object-cover rounded border border-gray-200" />

                                <div class="ml-4 flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                                    <p class="text-gray-600 text-sm">Color: {{ $item->variant_color ?? '-' }},
                                        Size: {{ $item->variant_size ?? '-' }}</p>
                                    <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                        each</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- Order Summary & Info -->
                <div class="space-y-6">
                    @if ($order->status === 'pending')
                    <div class="text-center my-6">
                        <p class="text-gray-600">Pesanan kamu belum dibayar.</p>
                        <a href="{{ route('customer.checkout.payment', ['order_code' => $order->order_code, 'snapToken' => $snapToken]) }}"
                            class="inline-block mt-4 bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                            🔁 Bayar Sekarang
                        </a>

                    </div>
                    @endif
                    <div class="rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount</span>
                                <span class="text-green-600">-Rp{{ number_format($order->discount, 0, ',', '.')
                                    }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 👇 Tambahkan tombol-tombol di sini -->
                        <div class="mt-6 pt-4 flex flex-col w-full gap-4">
                            <button
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-redo mr-2"></i>Reorder
                            </button>
                            <button
                                class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-star mr-2"></i>Write Review
                            </button>
                            <button
                                class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-download mr-2"></i>Download Invoice
                            </button>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold mb-4">Payment Method</h3>
                        @php $payment = $order->payment @endphp
                        <div class="flex items-center">
                            <i class="fas fa-credit-card text-gray-400 mr-3"></i>
                            <div>
                                <p class="font-medium">{{ ucfirst($payment->payment_type ?? 'Midtrans') }}</p>
                                <p class="text-sm text-gray-600">Transaction ID: {{ $payment->snap_token ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($payment && $payment->va_number)
                    <div class="rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold mb-4">Tracking Information</h3>
                        <div class="text-sm">
                            <p class="font-medium">Virtual Account</p>
                            <p class="text-blue-600 mb-3">{{ $payment->va_number }}</p>

                            <p class="font-medium">Bank</p>
                            <p class="text-gray-600 mb-3">{{ strtoupper($payment->bank) }}</p>

                            <p class="font-medium">Transaction Status</p>
                            <p class="text-gray-600">{{ ucfirst($payment->transaction_status) }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-customer.layout.layout>
