{{-- resources/views/components/nav-link.blade.php --}}
@props(['href', 'active' => false])
@php
    $classes = $active
        ? 'font-semibold underline underline-offset-4'
        : 'hover:underline hover:underline-offset-4';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$classes transition text-sm"]) }}>
    {{ $slot }}
</a>
