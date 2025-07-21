@props([
    'slug',
    'image',
    'name',
    'description',
    'price',
    'is_stock' => true
])

@php
    $finalImage = empty($image) ? asset('/assets/images/product.png') : asset('storage/'.$image);
@endphp

<div class="w-full flex flex-col gap-4">
    <!-- IMAGE -->
    <a href="{{ $is_stock ? route('customer.products.show', ['slug' => $slug]) : '#' }}"
       class="relative w-full h-80 block group {{ !$is_stock ? 'pointer-events-none' : '' }}">

        {{-- Overlay jika out of stock --}}
        @unless($is_stock)
            <div class="absolute inset-0 bg-black/40 z-20 flex items-center justify-center">
                <span class="transform rotate-[-15deg] text-white text-lg font-bold px-4 py-2 bg-gray-700/80 rounded shadow-lg">
                    OUT OF STOCK
                </span>
            </div>
        @endunless

        {{-- IMAGE Normal + Hover --}}
        <img
            src="{{ $finalImage }}"
            alt="{{ $name }}"
            class="absolute inset-0 w-full h-full object-cover z-10 group-hover:opacity-0 transition-opacity duration-300"
        />
        <img
            src="{{ $finalImage }}"
            alt="{{ $name }} hover"
            class="absolute inset-0 w-full h-full object-cover"
        />
    </a>

    <!-- TEXT -->
    <div class="flex flex-col gap-1 px-2">
        <span class="font-medium text-gray-800 text-base truncate {{ !$is_stock ? 'opacity-50' : '' }}">
            {{ $name }}
        </span>
        <span class="font-semibold text-primary text-lg {{ !$is_stock ? 'opacity-50' : '' }}">
            Rp {{ number_format($price, 0, ',', '.') }}
        </span>
        <p class="text-sm text-gray-500 line-clamp-2 {{ !$is_stock ? 'opacity-50' : '' }}">
            {{ $description }}
        </p>
    </div>

    <!-- CTA -->
    <div class="px-2">
        @if($is_stock)
            <a href="{{ route('customer.products.show', ['slug' => $slug]) }}"
                class="rounded-md ring-1 ring-primary text-primary w-max py-2 px-4 text-xs hover:bg-primary hover:text-white transition">
                Lihat Detail
            </a>
        @else
            <button
                disabled
                class="rounded-md ring-1 ring-gray-300 bg-gray-100 text-gray-400 w-max py-2 px-4 text-xs cursor-not-allowed">
                Out of Stock
            </button>
        @endif
    </div>
</div>
