<x-customer.layout.layout>
    <section class="container-custom">
        {{-- Page Header --}}
        <x-customer.page-header title="Shopping Cart" description="Review your items before checkout" />
        <x-customer.orders.checkout-progress :current="2" />

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Shipping Address Section --}}
            <div class="lg:w-2/3">
                <div class="">
                    <h2 class="text-xl font-semibold mb-6">Shipping Address</h2>

                    @if ($defaultAddress)
                    <x-customer.orders.address-card :addresses="$addresses" :address="$defaultAddress" />

                    <x-customer.orders.shipping-checker :destination-id="$defaultAddress->raja_ongkir_id"
                        :weight="100" />
                    @else
                    <div class="p-4 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded mb-4">
                        Belum ada alamat. Silakan tambahkan dulu.
                        <a href="{{ route('customer.address.create') }}" class="ml-2 text-primary underline text-sm">
                            Tambah Alamat
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Cek Ongkir --}}
            </div>

            {{-- Order Summary --}}
            <form action="{{ route('customer.checkout.order') }}" class="lg:w-1/3" method="">
                <div class=" p-6">
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
                        <input type="hidden" name="items[{{ $index }}][product_name]"
                            value="{{ $item->product->name }}">
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

                    @if ($defaultAddress)
                    <input type="hidden" name="raja_ongkir_id" value="{{ $defaultAddress->raja_ongkir_id }}">
                    <input type="hidden" name="shipping_address" id="shipping_address"
                        value="{{ $defaultAddress->address_line1 }}{{ $defaultAddress->address_line2 ? ', ' . $defaultAddress->address_line2 : '' }}">
                    @endif
                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="discount" value="{{ $discount }}">
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="{{ session('ongkir') ?? 0 }}">


                    <input type="hidden" name="total" id="total-amount-value" value="{{ $total }}">
                    <button id="pay-button" type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary transition">Pay
                        with Midtrans</button>

                    <div class="mt-4 text-center text-sm text-gray-600 flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i><span>Secure payment powered by Midtrans</span>
                    </div>
                </div>
            </form>
        </div>


    </section>

    {{-- Script --}}

</x-customer.layout.layout>
