<x-customer.layout.layout>

    <section class="container-custom">

        <!-- Page Header -->
        <x-customer.page-header title="Shopping Cart" description="Review your items before checkout" />


        <!-- Checkout Progress -->
        <x-customer.orders.checkout-progress :current="1" />

        <!-- Cart Content -->
        <div class="">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-[60%]">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-6">Cart Items ({{ $cartItems->count() }})</h2>

                        @forelse ($cartItems as $item)

                        <div class="flex items-center border-b border-gray-200 pb-6 mb-6">
                            <img src="{{ $item->variant?->image ? asset('storage/' . $item->variant->image) : asset('assets/static-images/no-image.jpg') }}"
                                alt="{{ $item->product->name }}" class="w-20 h-28 object-cover rounded">


                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 text-sm">
                                    @if ($item->variant->color)
                                    Color: {{ $item->variant->color->name }}<br>
                                    @endif

                                    @if ($item->variant->size)
                                    Size: {{ $item->variant->size->name }}
                                    @endif

                                </p>
                                <p class="text-primary font-semibold mt-1">
                                    Rp.{{ number_format($item->variant->price ?? $item->product->price, 2) }}
                                </p>
                            </div>

                            <div class="flex items-center space-x-3">
                                <form action="{{ route('customer.cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="action" value="decrease">
                                    <button
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                </form>

                                <span class="font-semibold">{{ $item->quantity }}</span>

                                <form action="{{ route('customer.cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="action" value="increase">
                                    <button
                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </form>
                            </div>

                            <form action="{{ route('customer.cart.destroy', $item->id) }}" method="POST" class="ml-4">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @empty
                        <p class="text-gray-500">Your cart is empty.</p>
                        @endforelse

                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-[40%]">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">Rp.{{ number_format($subtotal, 2) }}</span>
                            </div>

                            {{-- ⬇️ Tambahkan di sini --}}
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount {{ $discount > 0 ? '('.$promo['code'].')' : ''
                                    }}</span>
                                <span class="font-semibold text-red-600">- Rp.{{ $discount > 0 ?
                                    number_format($discount, 2) : '0'}}</span>
                            </div>

                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-lg font-semibold text-primary">Rp.{{ number_format($total, 2)
                                        }}</span>
                                </div>
                            </div>
                        </div>


                        @if(session('promo.success'))
                        <div class="text-green-600 mb-4">{{ session('promo.success') }}</div>
                        @endif
                        @if(session('promo.error'))
                        <div class="text-red-600 mb-4">{{ session('promo.error') }}</div>
                        @endif

                        <!-- Promo Code -->
                        <form action="{{ route('customer.cart.applyPromo') }}" method="POST" class="mb-6">
                            @csrf
                            <label class="block text-sm font-medium text-gray-700 mb-2">Promo Code</label>
                            <div class="flex">
                                <input type="text" name="promo_code" placeholder="Enter code"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                <button type="submit"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-lg hover:bg-gray-300">Apply</button>
                            </div>
                        </form>

                        @if (!empty($promo) && isset($promo['code'], $promo['type'], $promo['value']))
                        <div
                            class="flex items-center justify-between mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded">
                            <div>
                                Promo <strong>{{ $promo['code'] }}</strong> aktif.
                                @if ($promo['type'] === 'percentage')
                                Diskon {{ $promo['value'] }}%
                                @else
                                Diskon Rp{{ number_format($promo['value'], 2) }}
                                @endif
                            </div>

                            <form action="{{ route('customer.cart.removePromo') }}" method="POST" class="ml-4">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline text-sm">
                                    Hapus Promo
                                </button>
                            </form>
                        </div>
                        @endif


                        <!-- Checkout Form -->
                        <form action="{{ route('customer.checkout.index') }}" method="GET">
                            @csrf

                            <!-- Hidden Inputs -->
                            @if (!empty($promo) && isset($promo['code']))
                            <input type="hidden" name="promo_code" value="{{ $promo['code'] }}">
                            @endif

                            <button type="submit"
                                class="block w-full bg-primary text-white py-3 rounded-lg font-semibold text-center hover:bg-primary transition duration-300 mb-4">
                                Proceed to Checkout
                            </button>
                        </form>


                        <a href="{{ route('customer.products.index') }}"
                            class="block w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold text-center hover:bg-gray-50 transition duration-300">
                            Continue Shopping
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-customer.layout.layout>
