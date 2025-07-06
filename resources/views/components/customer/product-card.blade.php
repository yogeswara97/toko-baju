@props([
    'slug',
    'image',
    'name',
    'description',
    'price'
])

<div class="w-full flex flex-col gap-4">
    <!-- IMAGE -->
    <a href="{{ route('customer.products.show', ['slug' => $slug]) }}" class="relative w-full h-80 block group">
        <img
            src="{{ $image ?? asset('/assets/images/product.png') }}"
            alt="{{ $name }}"
            class="absolute inset-0 w-full h-full object-cover z-10 group-hover:opacity-0 transition-opacity duration-300"
        />
        {{-- Gambar hover kedua (placeholder, opsional) --}}
        <img
            src="{{ $image ?? asset('/assets/images/product-hover.png') }}"
            alt="{{ $name }}"
            class="absolute inset-0 w-full h-full object-cover"
        />
    </a>

    <!-- TEXT -->
    <div class="flex flex-col gap-1 px-2">
        <span class="font-medium text-gray-800 text-base truncate">{{ $name }}</span>
        <span class="font-semibold text-pink-600 text-lg">Rp {{ number_format($price, 0, ',', '.') }}</span>
        <p class="text-sm text-gray-500 line-clamp-2">
            {{ $description }}
        </p>
    </div>

    <!-- CTA -->
    <div class="px-2">
        <a href="{{ route('customer.products.show', ['slug' => $slug]) }}"
            class="rounded-full ring-1 ring-pink-500 text-pink-500 w-max py-2 px-4 text-xs hover:bg-pink-500 hover:text-white transition">
            Lihat Detail
        </a>
    </div>
</div>
