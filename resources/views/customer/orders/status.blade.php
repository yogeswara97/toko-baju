@php
    $data = [
        'success' => [
            'icon' => '🎉',
            'title' => 'Pembayaran Berhasil!',
            'message' => 'Yeay! Pesanan kamu sedang diproses.',
            'colorClass' => 'green',
            'buttonClass' => 'bg-green-600 hover:bg-green-700',
            'button' => [
                'text' => 'Lihat Pesanan',
                'route' => route('customer.profile.order', ['order_code' => $orderCode]),
            ]
        ],
        'pending' => [
            'icon' => '⏳',
            'title' => 'Pembayaran Tertunda',
            'message' => 'Pembayaran belum selesai.',
            'colorClass' => 'yellow',
            'buttonClass' => 'bg-yellow-600 hover:bg-yellow-700',
            'button' => [
                'text' => 'Cek Pesanan',
                'route' => route('customer.profile.order', ['order_code' => $orderCode]),
            ]
        ],
        'failed' => [
            'icon' => '❌',
            'title' => 'Pembayaran Gagal',
            'message' => 'Ups! Pembayaran gagal diproses.',
            'colorClass' => 'red',
            'buttonClass' => 'bg-red-600 hover:bg-red-700',
            'button' => [
                'text' => 'Kembali ke Keranjang',
                'route' => route('customer.cart.index'),
            ]
        ]
    ];
@endphp

@if(isset($data[(string)$status]))
    <x-customer.layout.layout>
        <section class="container-custom flex flex-col justify-center items-center text-center min-h-[calc(100vh-20rem)] py-20">
            <h2 class="text-3xl font-bold text-{{ $data[$status]['colorClass'] }}-600 mb-4">
                {{ $data[$status]['icon'] }} {{ $data[$status]['title'] }}
            </h2>
            <p class="text-gray-600 mb-6">{{ $data[$status]['message'] }}</p>

            <a href="{{ $data[$status]['button']['route'] }}"
                class="{{ $data[$status]['buttonClass'] }} text-white px-6 py-3 rounded-lg font-semibold">
                {{ $data[$status]['button']['text'] }}
            </a>
        </section>
    </x-customer.layout.layout>
@else
    <x-customer.layout.layout>
        <section class="container-custom py-20 text-center text-red-600">
            <h2 class="text-2xl font-bold">Status tidak dikenali 😕</h2>
        </section>
    </x-customer.layout.layout>
@endif
