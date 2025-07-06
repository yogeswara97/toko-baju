<x-customer.layout.layout>
    <section class="container-custom">
        {{-- Page Header --}}
        <x-customer.page-header title="Shopping Cart" description="Review your items before checkout" />
        <x-customer.checkout-progress :current="2" />

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Shipping Address Section --}}
            <div class="lg:w-2/3">
                <div class="bg-white">
                    <h2 class="text-xl font-semibold mb-6">Shipping Address</h2>

                    @if ($defaultAddress)
                        <div class="bg-gray-100 p-4 rounded-lg border border-gray-300 mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $defaultAddress->address_line1 }}</p>
                                    @if ($defaultAddress->address_line2)
                                        <p class="text-sm text-gray-600">{{ $defaultAddress->address_line2 }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600 font-medium">{{ $defaultAddress->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $defaultAddress->subdistrict_name }}, {{ $defaultAddress->district_name }},
                                        {{ $defaultAddress->city_name }}, {{ $defaultAddress->province_name }} -
                                        {{ $defaultAddress->zip_code }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $defaultAddress->country }}</p>
                                    <span class="inline-block text-xs px-2 py-1 mt-1 rounded {{ $defaultAddress->is_default ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $defaultAddress->is_default ? '✅ Alamat Utama' : '📦 Alamat Lainnya' }}
                                    </span>
                                </div>
                                <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Ganti Alamat
                                </button>
                            </div>
                            <input type="hidden" name="address_id" value="{{ $defaultAddress->id }}">
                        </div>
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
                <form action="{{ route('customer.cek-ongkir') }}" method="POST" id="ongkir-form" class="mb-4">
                    @csrf
                    <input type="hidden" name="destination_id" value="{{ $defaultAddress->raja_ongkir_id }}">
                    <input type="hidden" name="shipping_cost" id="shipping_cost">

                    <div class="space-y-6">
                        <div>
                            <label for="courier" class="block text-sm font-medium text-gray-700 mb-1">Kurir</label>
                            <select id="courier" name="courier"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS</option>
                            </select>
                        </div>

                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Berat (gram)</label>
                            <input type="number" id="weight" name="weight" min="1" value="1000"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" />
                        </div>

                        {{-- Result Area --}}
                        <div id="ongkir-result" class="mt-4 text-sm text-gray-800"></div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition text-sm">
                            🚚 Cek Ongkir
                        </button>
                    </div>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-1/3">
                <div class="bg-white p-6">
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

                    @php
                        $priceItems = [
                            ['label' => 'Subtotal', 'value' => $subtotal],
                            ['label' => 'Shipping', 'value' => session('ongkir') ?? 0],
                            ['label' => 'Tax', 'value' => null],
                        ];
                    @endphp

                    <div class="space-y-3 mb-6 border-t border-gray-200 pt-4">
                        @foreach ($priceItems as $item)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ $item['label'] }}</span>
                                <span class="font-semibold">
                                    @if (!is_null($item['value']))
                                        Rp{{ number_format($item['value'], 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        @endforeach

                        @if ($discount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-semibold text-red-500">-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total</span>
                                <span class="text-lg font-semibold text-blue-600" id="total-amount"
                                    data-subtotal="{{ $subtotal }}"
                                    data-discount="{{ $discount }}">
                                    Rp{{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <button id="pay-button"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Pay with Midtrans
                    </button>

                    <div class="mt-4 text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                            <i class="fas fa-lock"></i>
                            <span>Secure payment powered by Midtrans</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Address Modal --}}
        <x-customer.address :addresses="$addresses" />
    </section>

    {{-- Script --}}
    <script>
        document.getElementById('ongkir-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const resultDiv = document.getElementById('ongkir-result');
            resultDiv.innerHTML = '⏳ Loading...';

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const data = await res.json();

                if (Array.isArray(data) && data.length > 0) {
                    let html = '<h4 class="font-semibold mb-2">Pilih Layanan Pengiriman:</h4>';

                    data.forEach((service, index) => {
                        const id = `shipping-option-${index}`;
                        html += `
                            <label for="${id}" class="shipping-option block border border-gray-300 rounded-lg p-4 mb-2 cursor-pointer transition">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium text-blue-800">${service.service} - ${service.description}</div>
                                        <div class="text-sm text-gray-600">Kurir: ${service.name}</div>
                                        <div class="text-sm">Biaya: <span class="font-semibold text-green-600">Rp${Number(service.cost).toLocaleString('id-ID')}</span></div>
                                        <div class="text-sm">Estimasi: ${service.etd || 'Tidak tersedia'} hari</div>
                                    </div>
                                    <input type="radio" name="selected_shipping" id="${id}" class="shipping-radio" value="${service.cost}" />
                                </div>
                            </label>`;
                    });

                    resultDiv.innerHTML = html;

                    // Listener buat highlight dan update total
                    const radios = resultDiv.querySelectorAll('.shipping-radio');
                    radios.forEach(radio => {
                        radio.addEventListener('change', (e) => {
                            document.querySelectorAll('.shipping-option').forEach(el => {
                                el.classList.remove('border-blue-900', 'bg-blue-100');
                                el.classList.add('border-gray-300', 'bg-white');
                            });

                            const selectedLabel = e.target.closest('.shipping-option');
                            selectedLabel.classList.add('border-blue-900', 'bg-blue-100');
                            selectedLabel.classList.remove('border-gray-300', 'bg-white');

                            const shippingCost = parseInt(e.target.value);
                            document.getElementById('shipping_cost').value = shippingCost;

                            const subtotal = parseInt(document.getElementById('total-amount').dataset.subtotal);
                            const discount = parseInt(document.getElementById('total-amount').dataset.discount || 0);
                            const newTotal = subtotal + shippingCost - discount;

                            document.getElementById('total-amount').innerText = 'Rp' + newTotal.toLocaleString('id-ID');
                        });
                    });
                } else {
                    resultDiv.innerHTML = '❌ Tidak ada opsi pengiriman tersedia.';
                }
            } catch (err) {
                resultDiv.innerHTML = '❌ Gagal mengambil data ongkir.';
                console.error(err);
            }
        });
    </script>
</x-customer.layout.layout>
