<x-admin.layout.layout :title="'User Detail: ' . $user->name">
    <x-admin.layout.header :title="'User Detail'" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('admin.dashboard')],
        ['label' => 'Users', 'url' => route('admin.users.index')],
        ['label' => $user->name],
    ]" />

    <div class="flex flex-col md:flex-row gap-6 mb-6">

        {{-- Left Section - User Info (60%) --}}
        <div class="md:w-3/5 bg-white rounded-xl shadow p-6 space-y-6">
            {{-- IMAGE UPLOAD WITH PREVIEW --}}
            <div class="space-y-2 text-center">
                <h3 class="font-semibold text-lg mb-2">User Profile Image</h3>
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border border-gray-300 shadow-sm">
                    <img src="{{ !empty($user->image) ? asset('storage/' . $user->image) : asset('assets/static-images/no-image.jpg') }}"
                        alt="User Image" class="w-full h-full object-cover" />
                </div>
            </div>

            {{-- User Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">Name</label>
                    <div class="input bg-gray-100">{{ $user->name }}</div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Email</label>
                    <div class="input bg-gray-100">{{ $user->email }}</div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Phone Number</label>
                    <div class="input bg-gray-100">{{ $user->phone_number ?? '-' }}</div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Role</label>
                    <div class="input bg-gray-100">{{ ucfirst($user->role) }}</div>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Status</label>
                    <div class="input bg-gray-100">
                        <span class="px-2 py-1 text-xs font-semibold rounded
                        {{ $user->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

            </div>

            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="button-mini-edit">Edit</a>
        </div>

        {{-- Right Section - Top Products (40%) --}}
        <div class="md:w-2/5 bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Top Products</h3>
            </div>
            <div class="overflow-x-auto">
                <x-admin.table.table :headers="['Product', 'Total Purchased']">
                    @forelse ($topProducts as $product)
                    <tr class="bg-white border-b border-gray-200">
                        <td class="px-4 py-3">{{ $product['product_name'] }}</td>
                        <td class="px-4 py-3">{{ $product['total_quantity'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center text-gray-500 py-4">Belum pernah beli produk.</td>
                    </tr>
                    @endforelse
                </x-admin.table.table>
            </div>
        </div>
    </div>


    <div class="grid md:grid-cols-5 gap-6 mb-6">

        {{-- Promo Usage (40%) --}}
        <div class="md:col-span-2 bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Promo Usage</h3>
            </div>
            <div class="overflow-x-auto">
                <x-admin.table.table :headers="['Code', 'Value', 'Uses']">
                    @forelse ($user->promoCodeUsages as $usage)
                    <tr class="bg-white border-b border-gray-200">
                        <td class="px-4 py-3 font-semibold">{{ $usage->promoCode->code }}</td>
                        <td class="px-4 py-3">
                            {{ $usage->promoCode->type === 'percentage' ? $usage->promoCode->value . '%' : 'Rp' .
                            number_format($usage->promoCode->value, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">{{ $usage->uses }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-500 py-4">Belum pernah pakai promo.</td>
                    </tr>
                    @endforelse
                </x-admin.table.table>
            </div>
        </div>

        {{-- Addresses (60%) --}}
        <div class="md:col-span-3 bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Addresses</h3>
            </div>
            <div class="overflow-x-auto">
                <x-admin.table.table :headers="['Name', 'Addres Line', 'City', 'Postal Code']">
                    @forelse ($user->addresses as $address)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $address->name }}</td>
                        <td class="px-4 py-3">{{ $address->address_line1 }}</td>
                        <td class="px-4 py-3">{{ $address->district_name }}</td>
                        <td class="px-4 py-3">{{ $address->zip_code }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No address found.</td>
                    </tr>
                    @endforelse
                </x-admin.table.table>
            </div>
        </div>

    </div>


    {{-- Orders (1 kolom full karena lebih lebar) --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Orders</h3>
            <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}"
                class="text-sm font-medium text-blue-600 hover:underline">
                View All
            </a>
        </div>

        <div class="overflow-x-auto">
            <x-admin.table.table
                :headers="['Order Code', 'User', 'Total', 'Status', 'Shipping', 'Created At', 'Action']">
                @foreach ($user->orders as $order)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono">{{ $order->order_code }}</td>
                    <td class="px-6 py-4">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                    @if ($order->status == 'pending') bg-yellow-200 text-yellow-800
                    @elseif($order->status == 'paid') bg-blue-200 text-blue-800
                    @elseif($order->status == 'shipped') bg-indigo-200 text-indigo-800
                    @elseif($order->status == 'completed') bg-green-200 text-green-800
                    @elseif($order->status == 'cancelled') bg-red-200 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $shippingColors = [
                        'requested' => 'bg-slate-200 text-slate-800',
                        'picked_up' => 'bg-blue-200 text-blue-800',
                        'in_transit' => 'bg-cyan-200 text-cyan-800',
                        'out_for_delivery' => 'bg-amber-200 text-amber-800',
                        'delivered' => 'bg-green-200 text-green-800',
                        'confirmed' => 'bg-emerald-200 text-emerald-800',
                        'cancelled' => 'bg-red-200 text-red-800',
                        ];
                        $shippingStatus = strtolower($order->shipping_status);
                        $shippingBadgeClass = $shippingColors[$shippingStatus] ?? 'bg-gray-200 text-gray-800';
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $shippingBadgeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $shippingStatus)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="button-mini-detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </x-admin.table.table>
        </div>
    </div>




</x-admin.layout.layout>
