<x-admin.layout.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-admin.layout.header title="Profile" :breadcrumbs="[['label' => 'Profile']]" />

    <section class="">
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- KIRI: Profile & Address -->
            <div class="w-full lg:w-1/3 space-y-6">

                <!-- Profile Card -->
                <div class="border border-gray-200 rounded-xl p-6 space-y-4">
                    <div class="flex justify-center">
                        @php
                            $image = auth()->user()->image ? asset('storage/'. auth()->user()->image) : asset('assets/static-images/no-image.jpg');
                        @endphp

                        <img class="w-24 h-24 rounded-full ring-2 ring-gray-200 object-cover bg-gray-200"
                             src="{{ $image }}" alt="Profile">
                    </div>

                    <div class="text-center space-y-1">
                        <h2 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-gray-500">{{ '@' . Str::slug(auth()->user()->name) }}</p>
                    </div>

                    <div class="text-sm text-gray-700 space-y-2">
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

                    <div class="flex justify-center space-x-3 pt-4">
                        <a href="{{ route('customer.profile.edit') }}"
                           class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 text-sm transition">
                            Edit Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Address Card -->
                <div class="border border-gray-200 rounded-xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">Addresses</h2>
                        <a href="{{ route('customer.address.create') }}"
                           class="bg-admin-primary text-white px-4 py-2 rounded hover:bg-admin-primary-dark text-sm transition">
                            + Tambah Alamat
                        </a>
                    </div>

                    @if ($admin->addresses->isEmpty())
                        <p class="text-sm text-gray-500">Kamu belum menambahkan alamat mana pun.</p>
                    @else
                        <ul class="space-y-6 text-sm">
                            @foreach ($admin->addresses as $address)
                                <li class="border-t border-gray-200 pt-4 flex justify-between items-start">
                                    <div class="space-y-1 text-gray-800">
                                        <p class="font-semibold text-base">{{ $address->name }}</p>
                                        <p>{{ $address->address_line1 }}</p>
                                        @if ($address->address_line2)
                                            <p>{{ $address->address_line2 }}</p>
                                        @endif
                                        <p>{{ $address->subdistrict_name }}, {{ $address->district_name }}, {{ $address->city_name }}, {{ $address->province_name }} - {{ $address->zip_code }}</p>
                                        <p>{{ $address->country }}</p>
                                        <span class="inline-block mt-2 text-xs font-medium px-2 py-1 rounded
                                            {{ $address->is_default ? 'bg-gray-100 text-admin-secondary' : 'bg-gray-100 text-gray-600' }}">
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
            </div>

            <!-- KANAN: Orders -->
            <div class="w-full lg:w-2/3">
                <div class="border border-gray-200 rounded-xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">Orders</h2>
                    </div>

                    @if ($admin->orders->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada pesanan yang dibuat.</p>
                    @else
                        <ul class="space-y-6 text-sm">
                            @foreach ($admin->orders as $order)
                                <li class="border-t border-gray-200 pt-4 flex justify-between items-start">
                                    <div class="space-y-1 text-gray-800">
                                        <p class="font-semibold text-base">Order #{{ $order->order_code }}</p>
                                        <p class="text-gray-500">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
                                        <p>Total: <span class="text-green-600 font-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                                        @php $statusColors = getStatusColors(); @endphp
                                        <span class="inline-block mt-2 text-xs font-medium px-2 py-1 rounded
                                            {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col items-end gap-2">
                                        <a href="{{ route('customer.profile.order', $order->order_code) }}"
                                           class="text-primary hover:underline">Lihat Detail</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </section>
</x-admin.layout.layout>
