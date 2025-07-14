<x-customer.layout.layout>
    <section class="container-custom pb-20">
        <x-customer.page-header title="Profile" description="Review your items before checkout" />

        <div class="flex flex-col lg:flex-row gap-10">

            <!-- KIRI: Profile & Address -->
            <div class="w-full lg:w-1/3 space-y-6">
                <!-- Profile Card -->
                <div class=" border border-gray-200 rounded-xl p-6">
                    <div class="flex justify-center mb-4">
                        @php
                        $image = auth()->user()->image ? asset(auth()->user()->image) : asset('assets/static-images/no-image.jpg');
                        @endphp

                        @if ($image)
                        <img class="w-24 h-24 rounded-full ring-2 ring-gray-200 object-cover bg-gray-200"
                            src="{{ $image }}" alt="Profile">
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
                <div class=" border border-gray-200 rounded-xl p-6">
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
            </div>


            <!-- KANAN: Orders -->
            <div class="w-full lg:w-2/3">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Orders</h2>

                @if ($orders->isEmpty())
                <p class="text-gray-500">Belum ada pesanan yang dibuat.</p>
                @else
                <ul class="space-y-6">
                    @foreach ($orders as $order)
                    <li class="border-b border-gray-200 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-base font-semibold text-gray-900">
                                    Order #{{ $order->order_code }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Tanggal: {{ $order->created_at->format('d M Y') }}
                                </p>
                                <p class="text-sm mt-1">
                                    <span class="text-gray-500">Total: </span>
                                    <span class="text-green-600 font-bold">
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </p>
                                @php $statusColors = getStatusColors(); @endphp
                                <span
                                    class="inline-block mt-2 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }} px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <a href="{{ route('customer.profile.order', $order->order_code) }}"
                                    class="text-sm text-primary hover:underline hover:text-primary-dark font-medium">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

        </div>
    </section>
</x-customer.layout.layout>
