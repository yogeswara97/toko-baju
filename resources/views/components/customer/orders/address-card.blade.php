@props(['address'])

<div class=" p-4 rounded-lg border border-gray-300 mb-4">
    <div class="flex justify-between items-start">
        <div>
            <p class="font-semibold text-gray-800">{{ $address->address_line1 }}</p>
            @if ($address->address_line2)
                <p class="text-sm text-gray-600">{{ $address->address_line2 }}</p>
            @endif
            <p class="text-sm text-gray-600 font-medium">{{ $address->name }}</p>
            <p class="text-sm text-gray-600">
                {{ $address->subdistrict_name }}, {{ $address->district_name }},
                {{ $address->city_name }}, {{ $address->province_name }} - {{ $address->zip_code }}
            </p>
            <p class="text-sm text-gray-600">{{ $address->country }}</p>
            <span class="inline-block text-xs px-2 py-1 mt-1 rounded {{ $address->is_default ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $address->is_default ? '✅ Alamat Utama' : '📦 Alamat Lainnya' }}
            </span>
        </div>
        <button data-modal-target="default-modal" data-modal-toggle="default-modal"
            class="text-white bg-primary hover:bg-primary focus:ring-4 focus:outline-none focus:ring-primary font-medium rounded-lg text-sm px-5 py-2.5">
            Ganti Alamat
        </button>
    </div>
    <input type="hidden" name="address_id" value="{{ $address->id }}">
</div>
