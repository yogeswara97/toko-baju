@props(['addresses'])

<div id="default-modal" tabindex="-1" aria-hidden="true"
    class=" hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[900] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50 h-screen">
    <div class="relative p-4 w-[50%] max-h-full">
        <div class="relative bg-secondary rounded-lg shadow">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Pilih Alamat Pengiriman
                </h3>
                <button type="button"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                    data-modal-hide="default-modal">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 space-y-4 max-h-[60vh] overflow-y-auto">
                @foreach ($addresses as $address)
                    <form method="POST" action="{{ route('customer.checkout.set-address') }}">
                        @csrf
                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                        <div class="border border-gray-300 p-4 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $address->address_line1 }}</p>
                                    @if ($address->address_line2)
                                        <p class="text-sm text-gray-600">{{ $address->address_line2 }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600 font-medium">{{ $address->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $address->subdistrict_name }}, {{ $address->district_name }},
                                        {{ $address->city_name }}, {{ $address->province_name }} -
                                        {{ $address->zip_code }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $address->country }}</p>
                                    <p class="text-sm text-gray-600">{{ $address->country }}</p><span
                                        class="inline-block text-xs px-2 py-1 mt-1 rounded
                    {{ $address->is_default ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $address->is_default ? '✅ Alamat Utama' : '📦 Alamat Lainnya' }}
                                    </span>
                                </div>
                                <button type="submit"
                                    class="text-sm bg-primary text-white px-3 py-1 rounded hover:bg-primary">
                                    Pilih
                                </button>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end items-center p-4 border-t border-gray-200 rounded-b">
                <button data-modal-hide="default-modal" type="button"
                    class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 hover:text-primary font-medium rounded-lg text-sm px-4 py-2">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
