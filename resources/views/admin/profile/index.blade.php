<x-admin.layout.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="max-w-5xl px-4 py-10 space-y-10">

        <h1 class="text-2xl font-bold text-gray-900">Your Profile Overview</h1>

        <!-- Card Container -->
        <div class="space-y-10">

            <!-- PROFILE + ORDERS -->
            <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Profile Info -->
                    <div class="space-y-4">
                        <img src="{{ $admin->image ? asset($admin->image) : asset('assets/static-images/no-image.jpg') }}"
                            class="w-24 h-24 rounded-full object-cover border border-gray-300" alt="Foto Profil">

                        <div>
                            <h2 class="text-xl font-semibold">{{ $admin->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                            <p class="text-sm text-gray-500">{{ $admin->phone_number }}</p>
                        </div>

                        <a href="{{ route('admin.profile.edit') }}"
                           class="inline-block mt-2 px-4 py-2 bg-gray-900 text-white text-sm rounded hover:bg-black transition">
                            Edit Profile
                        </a>
                    </div>

                    <!-- Orders List -->
                    <div class="lg:col-span-2 space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800">Recent Orders</h2>

                        @forelse ($admin->orders as $order)
                            <div class="border border-gray-200 rounded p-4 space-y-1">
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium text-gray-700">#{{ $order->id }}</span>
                                    <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                </div>
                                <div class="text-sm text-gray-500">Status: {{ ucfirst($order->status) }}</div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada order.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ADDRESSES -->
            <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm space-y-6">
                <h2 class="text-lg font-semibold text-gray-800">Saved Addresses</h2>

                @forelse ($admin->addressesimprov as $address)
                    <div class="border border-gray-200 rounded p-4 space-y-1">
                        <div class="font-medium text-sm text-gray-800">{{ $address->name }}</div>
                        <div class="text-sm text-gray-600">{{ $address->address_line1 }}</div>
                        @if($address->address_line2)
                            <div class="text-sm text-gray-600">{{ $address->address_line2 }}</div>
                        @endif
                        <div class="text-sm text-gray-500">
                            {{ $address->subdistrict_name }}, {{ $address->district_name }}, {{ $address->city_name }},
                            {{ $address->province_name }} - {{ $address->zip_code }}
                        </div>
                        @if($address->is_default)
                            <span class="inline-block text-xs text-white bg-green-600 px-2 py-0.5 rounded mt-2">Default</span>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada alamat tersimpan.</p>
                @endforelse
            </div>

        </div>
    </section>
</x-admin.layout.layout>
