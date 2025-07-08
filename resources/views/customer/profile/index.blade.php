<x-customer.layout.layout>
    <section class="container-custom py-10">
        <x-customer.page-header title="Profile" description="Review your items before checkout" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile -->
            <div class="p-0 flex flex-col">
                <div>
                    <div class="flex justify-center mb-4">
                        @php
                        $photo = auth()->user()->photo ?? null;
                        @endphp

                        @if ($photo)
                        <img class="w-24 h-24 rounded-full ring-2 ring-gray-200 object-cover bg-gray-200"
                            src="{{ $photo }}" alt="Profile">
                        @else
                        <div
                            class="w-24 h-24 rounded-full ring-2 ring-gray-200 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                            No Image
                        </div>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-center text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-500 text-center">{{ '@' . Str::slug(auth()->user()->name) }}</p>

                    <div class="mt-6 space-y-3 text-sm text-gray-700">
                        <div class="flex items-center">
                            <i class="fa-solid fa-envelope mr-2 text-gray-500 w-5 text-center"></i>
                            {{ auth()->user()->email }}
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-location-dot mr-2 text-gray-500 w-5 text-center"></i>
                            {{ auth()->user()->location ?? 'Belum diatur' }}
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-calendar-days mr-2 text-gray-500 w-5 text-center"></i>
                            Joined: {{ auth()->user()->created_at->format('M Y') }}
                        </div>
                    </div>

                    <div class="flex justify-center space-x-3 mt-6">
                        <button
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 text-sm transition">
                            Edit Profile
                        </button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Address & Orders -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Addresses -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Addresses</h2>
                        <a href="{{ route('customer.address.create') }}"
                            class="bg-primary text-white px-4 py-2 rounded hover:bg-primary text-sm transition">
                            + Tambah Alamat
                        </a>
                    </div>

                    @if ($addresses->isEmpty())
                    <p class="text-gray-500">Kamu belum menambahkan alamat mana pun.</p>
                    @else
                    <ul class="space-y-6">
                        @foreach ($addresses as $address)
                        <li class="border-t border-gray-200 pt-4 flex justify-between items-start">
                            <div class="text-sm text-gray-800 space-y-1">
                                <p class="font-semibold text-base">{{ $address->name }}</p>
                                <p>{{ $address->address_line1 }}</p>
                                @if ($address->address_line2)
                                <p>{{ $address->address_line2 }}</p>
                                @endif
                                <p>{{ $address->subdistrict_name }}, {{ $address->district_name }}, {{
                                    $address->city_name }}, {{ $address->province_name }} - {{ $address->zip_code }}</p>
                                <p>{{ $address->country }}</p>
                                <span
                                    class="inline-block mt-2 text-xs font-medium px-2 py-1 rounded
                                            {{ $address->is_default ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $address->is_default ? '✅ Alamat Utama' : '📦 Alamat Lainnya' }}
                                </span>
                            </div>

                            <div class="flex flex-col items-end gap-2 text-sm">
                                <a href="{{ route('customer.address.edit', $address->id) }}"
                                    class="text-primary hover:underline">Edit</a>
                                <form action="{{ route('customer.address.destroy', $address->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus alamat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>

                <!-- Orders -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Orders</h2>
                    <ul class="space-y-6">
                        <li class="border-t border-gray-200 pt-4 flex justify-between items-start">
                            <div>
                                <p class="text-gray-900 font-medium">Order #1001 - <span
                                        class="text-green-600 font-bold">$49.99</span></p>
                                <p class="text-gray-500 text-sm">Placed: 2025-05-20 | Status: Delivered</p>
                            </div>
                            <a href="{{ route('customer.profile.order', ['slug' => '1001']) }}"
                                class="text-primary hover:underline text-sm">View Details</a>
                        </li>
                    </ul>
                    <button class="mt-6 text-sm px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">
                        View All Orders
                    </button>
                </div>
            </div>
        </div>
    </section>
</x-customer.layout.layout>
