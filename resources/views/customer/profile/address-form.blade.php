<x-customer.layout.layout>
    <section class="container-custom">
        <div class="p-6 sm:p-8 md:p-10">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ $mode === 'edit' ? 'Edit Alamat' : ($mode === 'show' ? 'Detail Alamat' : 'Tambah Alamat') }}
            </h2>

            @if ($mode !== 'show')
            <form action="{{ $mode === 'edit' ? route('address.update', $address->id) : route('customer.address.store') }}"
                method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @if($mode === 'edit') @method('PUT') @endif
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @endif

                    {{-- Hidden Inputs --}}
                    <input type="hidden" name="raja_ongkir_id" id="raja_ongkir_id"
                        value="{{ old('raja_ongkir_id', $address->raja_ongkir_id ?? '') }}">
                    <input type="hidden" name="subdistrict_name" id="subdistrict_name"
                        value="{{ old('subdistrict_name', $address->subdistrict_name ?? '') }}">
                    <input type="hidden" name="district_name" id="district_name"
                        value="{{ old('district_name', $address->district_name ?? '') }}">
                    <input type="hidden" name="city_name" id="city_name"
                        value="{{ old('city_name', $address->city_name ?? '') }}">
                    <input type="hidden" name="province_name" id="province_name"
                        value="{{ old('province_name', $address->province_name ?? '') }}">
                    <input type="hidden" name="zip_code" id="zip_code"
                        value="{{ old('zip_code', $address->zip_code ?? '') }}">

                    {{-- Nama Alamat --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Nama Alamat</label>
                        <input type="text" name="name" value="{{ old('name', $address->name ?? '') }}"
                            class="w-full mt-1 px-4 py-2 border {{ $mode === 'show' ? 'bg-gray-100' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                            {{ $mode==='show' ? 'readonly' : 'required' }}>
                    </div>

                    {{-- Alamat Lengkap --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <input type="text" name="address_line1"
                            value="{{ old('address_line1', $address->address_line1 ?? '') }}"
                            class="w-full mt-1 px-4 py-2 border {{ $mode === 'show' ? 'bg-gray-100' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                            {{ $mode==='show' ? 'readonly' : 'required' }}>
                    </div>

                    {{-- Detail Alamat --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Detail Alamat (Opsional)</label>
                        <input type="text" name="address_line2"
                            value="{{ old('address_line2', $address->address_line2 ?? '') }}"
                            class="w-full mt-1 px-4 py-2 border {{ $mode === 'show' ? 'bg-gray-100' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                            {{ $mode==='show' ? 'readonly' : '' }}>
                    </div>

                    {{-- Lokasi Autocomplete --}}
                    <div class="col-span-1 md:col-span-2">
                        @if ($mode !== 'show')
                        <label for="destination-search" class="block text-sm font-medium text-gray-700 mb-1">Cari
                            Lokasi</label>
                        <div class="relative w-full">
                            <input type="text" id="destination-search"
                                placeholder="Masukkan kelurahan / kecamatan / kota..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                autocomplete="off">
                            <div id="destination-dropdown"
                                class="hidden absolute z-10 bg-white border border-gray-200 rounded-b-lg shadow-md w-full max-h-60 overflow-y-auto mt-1">
                                <ul class="py-2 text-sm text-gray-900 space-y-1" id="destination-results"></ul>
                            </div>
                        </div>
                        @else
                        <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text"
                            value="{{ $address->subdistrict_name }}, {{ $address->district_name }}, {{ $address->city_name }}, {{ $address->province_name }}"
                            readonly class="w-full mt-1 px-4 py-2 border bg-gray-100 rounded-xl focus:outline-none">
                        @endif
                    </div>

                    {{-- Default Checkbox --}}
                    <div class="col-span-1 md:col-span-2 flex items-center space-x-2">
                        <input type="checkbox" name="is_default" id="is_default"
                            class="form-checkbox rounded text-blue-600" {{ (old('is_default', $address->is_default ??
                        false)) ? 'checked' : '' }} {{ $mode === 'show' ? 'disabled' : '' }}>
                        <label for="is_default" class="text-sm text-gray-700">Jadikan alamat utama</label>
                    </div>

                    {{-- Submit --}}
                    @if ($mode !== 'show')
                    <div class="col-span-1 md:col-span-2 pt-2">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold transition duration-300">
                            Simpan Alamat
                        </button>
                    </div>
                    @endif

                    @if ($mode !== 'show')
            </form>
            @else
        </div>
        @endif
        </div>
    </section>



    {{-- Autocomplete Script --}}
    @push('scripts')
    @if ($mode !== 'show')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const input = document.getElementById("destination-search");
        const dropdown = document.getElementById("destination-dropdown");
        const resultList = document.getElementById("destination-results");

        let timeout;

        input.addEventListener("input", () => {
            const query = input.value.trim();

            clearTimeout(timeout);
            if (query.length < 3) {
                dropdown.classList.add("hidden");
                resultList.innerHTML = '';
                return;
            }

            // Tampilkan loading dulu
            resultList.innerHTML = '<li class="px-4 py-2 text-gray-500">Loading...</li>';
            dropdown.classList.remove("hidden");

            timeout = setTimeout(async () => {
                try {
                    const res = await fetch(`{{ route('customer.search-destination') }}?search=${encodeURIComponent(query)}`);
                    const resJson = await res.json();
                    const data = Array.isArray(resJson) ? resJson : resJson.data;

                    resultList.innerHTML = '';

                    if (!data || data.length === 0) {
                        resultList.innerHTML = '<li class="px-4 py-2 text-gray-500">Lokasi tidak ditemukan.</li>';
                        return;
                    }

                    data.forEach(item => {
                        const li = document.createElement("li");
                        li.innerHTML = `<a href="#" class="block px-4 py-2 hover:bg-gray-100 text-gray-800"
                            data-id="${item.id}"
                            data-label="${item.label}"
                            data-subdistrict="${item.subdistrict_name}"
                            data-district="${item.district_name}"
                            data-city="${item.city_name}"
                            data-province="${item.province_name}"
                            data-zip="${item.zip_code}">
                            ${item.label}
                        </a>`;

                        li.querySelector('a').addEventListener('click', (e) => {
                            e.preventDefault();
                            input.value = item.label;
                            document.getElementById('raja_ongkir_id').value = item.id;
                            document.getElementById('subdistrict_name').value = item.subdistrict_name;
                            document.getElementById('district_name').value = item.district_name;
                            document.getElementById('city_name').value = item.city_name;
                            document.getElementById('province_name').value = item.province_name;
                            document.getElementById('zip_code').value = item.zip_code;
                            dropdown.classList.add("hidden");
                        });

                        resultList.appendChild(li);
                    });

                } catch (err) {
                    resultList.innerHTML = '<li class="px-4 py-2 text-red-500">Gagal mengambil data.</li>';
                }
            }, 500); // delay biar ga spam request
        });

        // Close dropdown ketika klik di luar
        document.addEventListener("click", (e) => {
            if (!dropdown.contains(e.target) && e.target !== input) {
                dropdown.classList.add("hidden");
            }
        });
    });
    </script>
    @endif
    @endpush

</x-customer.layout.layout>
