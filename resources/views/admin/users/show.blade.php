<x-admin.layout.layout :title="'User Detail: ' . $user->name">
    <x-admin.layout.header :title="'User Detail'"
        :breadcrumbs="[['label' => 'Home', 'url' => route('admin.dashboard')], ['label' => 'Users', 'url' => route('admin.users.index')], ['label' => $user->name]]" />

    <div class="wrapper space-y-8 mb-4">

        {{-- === BASIC INFO === --}}
        {{-- IMAGE UPLOAD WITH PREVIEW --}}
        <div class="space-y-2">
            <label for="image" class="block font-semibold">Main USer Image</label>
            <div class="flex items-center gap-4">
                <div
                    class="w-32 h-50 rounded border border-dashed border-gray-300 flex items-center justify-center bg-gray-100 overflow-hidden">
                    <img id="image-preview"
                        src="{{ !empty($product->image) ? asset('storage/' . $product->image) : asset('assets/static-images/no-image.jpg') }}"
                        alt="Preview" class="w-full h-full object-cover" />
                </div>

                <div class="flex-1">
                    <input type="file" name="image" id="image" data-preview-id="image-preview"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        accept="image/*">

                    <p class="text-xs text-gray-500 mt-1">Recommended: square image, max 2MB</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name --}}
            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <div class="input bg-gray-100">{{ $user->name }}</div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <div class="input bg-gray-100">{{ $user->email }}</div>
            </div>

            {{-- Phone --}}
            <div>
                <label class="block mb-1 font-semibold">Phone Number</label>
                <div class="input bg-gray-100">{{ $user->phone_number ?? '-' }}</div>
            </div>

            {{-- Role --}}
            <div>
                <label class="block mb-1 font-semibold">Role</label>
                <div class="input bg-gray-100">{{ ucfirst($user->role) }}</div>
            </div>

            {{-- Status --}}
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


    </div>
    <div class="wrapper mb-4">

        {{-- Addresses --}}

        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-800">Addresses</h3>
        </div>

        <div class="overflow-auto">
            <x-admin.table.table :headers="['Name', 'Addres Line', 'Address Line 2', 'City', 'Postal Code']">
                @foreach ($user->addresses as $address)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $address->name }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $address->address_line1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $address->address_line2 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $address->district_name }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $address->zip_code }}</td>
                    {{-- <td class="px-6 py-4">
                        <span class="p-2 rounded-md {{ $statusColor }} bg-opacity-60">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">Rp{{ number_format($i * 100000, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="#" class="button-mini-show"><i class="fas fa-eye"></i></a>
                        <a href="#" class="button-mini-edit"><i class="fas fa-pencil"></i></a>
                    </td> --}}
                </tr>
                @endforeach
            </x-admin.table.table>
        </div>

    </div>

        {{-- Promo Used --}}
        {{-- <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Promo Usage</h3>
            </div>

            <div class="overflow-x-auto">
                <x-admin.table.table :headers="['Promo Code', 'Discount', 'Used At']">
                    @forelse ($user->promoUsages as $usage)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold">{{ $usage->promo->code }}</td>
                        <td class="px-6 py-4">Rp{{ number_format($usage->promo->discount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $usage->used_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No promo used yet.</td>
                    </tr>
                    @endforelse
                </x-admin.table.table>
            </div>
        </div> --}}



        {{-- Orders --}}
<div class="wrapper ">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-lg text-gray-800">Orders</h3>
        <a href="#" class="text-sm font-medium text-blue-600 hover:underline">View All</a>
    </div>

    <div class="overflow-auto">
        <x-admin.table.table :headers="['Order Code', 'Status', 'Total', 'Created At', 'Action']">
            @foreach ($user->orders as $order)
                @php
                    $status = $order->status;
                    $color = match($status) {
                        'pending' => 'bg-yellow-100 text-yellow-800 ring-1 ring-yellow-300',
                        'confirmed' => 'bg-green-100 text-green-800 ring-1 ring-green-300',
                        'cancelled' => 'bg-red-100 text-red-800 ring-1 ring-red-300',
                        default => 'bg-gray-100 text-gray-800 ring-1 ring-gray-300',
                    };
                @endphp
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $order->code }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                            class="button-mini-show">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-admin.table.table>
    </div>
</div>



</x-admin.layout.layout>
