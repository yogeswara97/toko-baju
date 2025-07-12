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



            <div class="lg:w-1/3">
                <div class=" p-6">
                    <h2 class="text-xl font-semibold mb-6">Order Summary</h2>
                    <div class="space-y-4 mb-6">
                        @foreach ($cartItems as $item)
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
                        @endforeach
                    </div>

                    <x-customer.orders.price-summary :subtotal="$subtotal" :shipping="$shippingCost ?? 0"
                        :discount="$discount" :total="$total" />

                    <form action="{{ route('customer.checkout.order') }}" method="POST">
                        @csrf

                        @if ($defaultAddress)
                        <input type="hidden" name="raja_ongkir_id" value="{{ $defaultAddress->raja_ongkir_id }}">
                        <input type="hidden" name="shipping_address"
                            value="{{ $defaultAddress->address_line1 }}{{ $defaultAddress->address_line2 ? ', ' . $defaultAddress->address_line2 : '' }}">
                        @endif

                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="{{ $shippingCost ?? 0 }}">

                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary transition">
                            Pay with Midtrans
                        </button>
                    </form>
                </div>
            </div>

        </div>


    </section>

    {{-- Script --}}

</x-customer.layout.layout>
