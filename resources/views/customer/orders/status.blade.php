@php
    $data = [
        'success' => [
            'icon' => '🎉',
            'title' => 'Pembayaran Berhasil!',
            'message' => 'Terima kasih! Pembayaran Anda telah berhasil dan pesanan sedang kami proses. Kami akan segera mengirimkannya ke tujuan Anda.',
            'colorClass' => 'green',
            'buttonClass' => 'bg-green-600 hover:bg-green-700',
            'button' => [
                'text' => 'Lihat Detail Pesanan',
                'route' => route('customer.profile.order', ['order_code' => $orderCode]),
            ]
        ],
        'pending' => [
            'icon' => '⏳',
            'title' => 'Pembayaran Tertunda',
            'message' => 'Pembayaran Anda belum selesai. Mohon segera selesaikan agar pesanan dapat segera kami proses.',
            'colorClass' => 'yellow',
            'buttonClass' => 'bg-yellow-600 hover:bg-yellow-700',
            'button' => [
                'text' => 'Selesaikan Pembayaran',
                'route' => url()->previous(),
            ]
        ],
        'failed' => [
            'icon' => '❌',
            'title' => 'Pembayaran Gagal',
            'message' => 'Maaf, terjadi kesalahan saat memproses pembayaran Anda. Silakan coba kembali atau gunakan metode pembayaran lain.',
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
            <p class="text-gray-600 mb-6 max-w-xl leading-relaxed">
                {{ $data[$status]['message'] }}
            </p>

            <a href="{{ $data[$status]['button']['route'] }}"
                class="{{ $data[$status]['buttonClass'] }} text-white px-6 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                {{ $data[$status]['button']['text'] }}
            </a>
        </section>
    </x-customer.layout.layout>
@else
    <x-customer.layout.layout>
        <section class="container-custom py-20 text-center text-red-600">
            <h2 class="text-2xl font-bold mb-2">Status Tidak Dikenali 😕</h2>
            <p class="text-gray-600">Sepertinya ada kesalahan dalam memuat status pembayaran. Silakan coba beberapa saat lagi atau hubungi tim kami untuk bantuan.</p>
        </section>
    </x-customer.layout.layout>
@endif
