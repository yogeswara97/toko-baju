<x-customer.layout.layout>
    <section class="container-custom">
        {{-- Page Header --}}
        <x-customer.page-header title="Shopping Cart" description="Review your items before checkout" />
        <x-customer.orders.checkout-progress :current="2" />

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Shipping Address Section --}}
            <div class="lg:w-2/3">
                <div class="bg-white">
                    <h2 class="text-xl font-semibold mb-6">Shipping Address</h2>

                    @if ($defaultAddress)
                        <x-customer.orders.address-card :address="$defaultAddress" />
                    @else
                        <div class="p-4 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded mb-4">
                            Belum ada alamat default. Silakan pilih dulu.
                            <button type="button" class="ml-2 text-blue-600 underline text-sm"
                                data-modal-toggle="addressModal">
                                Pilih Alamat
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Cek Ongkir --}}
                <x-customer.orders.shipping-checker :destination-id="$defaultAddress->raja_ongkir_id" :weight="100" />
            </div>

            {{-- Order Summary --}}
            <form action="{{ route('customer.checkout.order') }}" class="lg:w-1/3" method="">
                <div class="bg-white p-6">
                    <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

                    {{-- Cart Items --}}
                    <div class="space-y-4 mb-6">
                        @foreach ($cartItems as $index => $item)
                            <div class="flex items-center">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                    class="w-12 h-12 object-cover rounded">
                                <div class="ml-3 flex-1">
                                    <h4 class="font-medium text-sm">{{ $item->product->name }}</h4>
                                    <p class="text-xs text-gray-600">
                                        {{ $item->variant->color->name ?? '-' }},
                                        {{ $item->variant->size->name ?? '-' }} × {{ $item->quantity }}
                                    </p>
                                </div>
                                <span class="font-semibold text-sm">
                                    Rp{{ number_format($item->variant->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Hidden per item --}}
                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product->id }}">
                            <input type="hidden" name="items[{{ $index }}][product_variant_id]"
                                value="{{ $item->variant->id }}">
                            <input type="hidden" name="items[{{ $index }}][product_name]" value="{{ $item->product->name }}">
                            <input type="hidden" name="items[{{ $index }}][variant_color]"
                                value="{{ $item->variant->color->name ?? '' }}">
                            <input type="hidden" name="items[{{ $index }}][variant_size]"
                                value="{{ $item->variant->size->name ?? '' }}">
                            <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item->variant->price }}">
                            <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                            <input type="hidden" name="items[{{ $index }}][subtotal]"
                                value="{{ $item->variant->price * $item->quantity }}">
                        @endforeach
                    </div>

                    <x-customer.orders.price-summary :subtotal="$subtotal" :shipping="session('ongkir') ?? 0"
                        :discount="$discount" :total="$total" />

                    <input type="hidden" name="raja_ongkir_id" value="{{ $defaultAddress->raja_ongkir_id }}">
                    <input type="hidden" name="address_line1" value="{{ $defaultAddress->address_line1 }}">
                    <input type="hidden" name="address_line2" value="{{ $defaultAddress->address_line2 }}">
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="discount" value="{{ $discount }}">
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="{{ session('ongkir') ?? 0 }}">
                    <input type="hidden" name="total" id="total-amount-value" value="{{ $total }}">
                    <button id="pay-button" type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Pay
                        with Midtrans</button>

                    <div class="mt-4 text-center text-sm text-gray-600 flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i><span>Secure payment powered by Midtrans</span>
                    </div>
                </div>
            </form>
        </div>

        {{-- Address Modal --}}
        <x-customer.orders.address-modal :addresses="$addresses" />
    </section>

    {{-- Script --}}

</x-customer.layout.layout>
