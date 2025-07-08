@props(['href'])

@php
    $isHome = request()->routeIs('home');
    $baseClass = $isHome ? 'text-secondary' : 'text-black';
@endphp

<a href="{{ $href }}" {{ $attributes->merge([
    'class' => "$baseClass hover:underline hover:underline-offset-4 transition text-sm whitespace-nowrap"
]) }}>
    {{ $slot }}
</a>
