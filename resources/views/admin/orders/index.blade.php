<x-admin.layout.layout :title="'Orders'">
    <x-admin.layout.header title="Orders" :breadcrumbs="[['label' => 'Home', 'url' => route('admin.dashboard')], ['label' => 'Orders']]" />


    {{-- TABLE HEADER --}}
    <div class="bg-white rounded-t-lg shadow border border-gray-200">
        <x-admin.table.table-header :dataset="$userNames" :routeReset="route('admin.orders.index')">
            {{-- Optional filter/search slot --}}
        </x-admin.table.table-header>
    </div>

    {{-- TABLE BODY --}}
    <div class="overflow-x-auto rounded-b-lg shadow bg-white">
        <x-admin.table.table :headers="['Order Code', 'User', 'Total', 'Status', 'Shipping', 'Created At', 'Action']">
            @foreach ($orders as $order)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono">{{ $order->order_code }}</td>
                    <td class="px-6 py-4">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span
                            class="px-2 py-1 rounded text-xs font-semibold
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

    {{-- Pagination --}}
    <x-admin.table.table-navigation :dataset="$orders" :perPage="10" />
</x-admin.layout.layout>
