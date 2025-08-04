@props(['destinationId', 'weight' => 1000, 'defaultCourier' => 'jne'])

<form id="ongkir-form" action="{{ route('customer.cek-ongkir') }}" method="POST" class="mb-4">
    @csrf
    <input type="hidden" name="destination_id" value="{{ $destinationId }}">

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="courier" class="block text-sm font-medium text-gray-700 mb-1">Kurir</label>
                <select id="courier" name="courier"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-sm">
                    @foreach (['jne', 'tiki', 'pos', 'sicepat', 'jnt', 'anteraja', 'wahana', 'lion', 'ninja', 'indah', 'rex', 'sap', 'idl', 'jet', 'first'] as $courier)
                        <option value="{{ $courier }}" @selected($courier == $defaultCourier)>
                            {{ strtoupper($courier) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Berat (gram)</label>
                <input type="number" id="weight" name="weight" min="1" value="{{ $weight }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-sm" />
            </div>
        </div>

        <div id="ongkir-result" class="mt-4 text-sm text-gray-800"></div>

        <button type="submit"
            class="w-full bg-primary hover:bg-primary text-white font-medium py-2 px-4 rounded-lg transition text-sm">
            Cek Ongkir
        </button>
    </div>
</form>


@push('scripts')
    <script>
        document.getElementById('ongkir-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const resultDiv = document.getElementById('ongkir-result');

            resultDiv.innerHTML = `
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-spinner fa-spin text-primary text-base"></i>
                    Loading...
                </div>
            `;

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
                                        <div class="font-medium text-primary">${service.service} - ${service.description}</div>
                                        <div class="text-sm text-gray-600">Kurir: ${service.name}</div>
                                        <div class="text-sm">Biaya: <span class="font-semibold text-green-600">Rp${Number(service.cost).toLocaleString('id-ID')}</span></div>
                                        <div class="text-sm">Estimasi: ${service.etd || 'Tidak tersedia'} hari</div>
                                    </div>
                                    <input type="radio" name="selected_shipping" id="${id}" class="shipping-radio accent-primary " value="${service.cost}" />
                                </div>
                            </label>`;
                    });

                    resultDiv.innerHTML = html;

                    // Listener shipping radio
                    const radios = resultDiv.querySelectorAll('.shipping-radio');
                    radios.forEach(radio => {
                        radio.addEventListener('change', (e) => {
                            document.querySelectorAll('.shipping-option').forEach(el => {
                                el.classList.remove('border-primary',
                                    'bg-primary-light');
                                el.classList.add('border-gray-300');
                            });

                            const selectedLabel = e.target.closest('.shipping-option');
                            selectedLabel.classList.add('border-primary', 'bg-primary-light');
                            selectedLabel.classList.remove('border-gray-300');

                            const shippingCost = parseInt(e.target.value);
                            document.getElementById('shipping_cost').value = shippingCost;

                            // Update shipping summary
                            const shippingSummary = document.getElementById('summary-shipping');
                            if (shippingSummary) {
                                shippingSummary.innerText = 'Rp' + shippingCost.toLocaleString(
                                    'id-ID');
                            }

                            const subtotal = parseInt(document.getElementById('total-amount')
                                .dataset.subtotal);
                            const discount = parseInt(document.getElementById('total-amount')
                                .dataset.discount || 0);
                            const newTotal = subtotal + shippingCost - discount;

                            document.getElementById('total-amount').innerText = 'Rp' + newTotal
                                .toLocaleString('id-ID');
                            document.getElementById('total-amount-value').value = newTotal;
                        });
                    });
                } else {
                    resultDiv.innerHTML = '<p class="text-red-500">❌ Tidak ada opsi pengiriman tersedia.</p>';
                }
            } catch (err) {
                resultDiv.innerHTML =
                    '<p class="text-red-500">⚠️ Gagal mengambil data ongkir. Coba lagi nanti.</p>';
                console.error(err);
            }
        });
    </script>
@endpush
