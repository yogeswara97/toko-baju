@props(['href'])

@php
    $isHome = request()->routeIs('customer.home');
    $baseClass = $isHome ? 'md:text-secondary text-black' : 'text-black';
@endphp

<a href="{{ $href }}" {{ $attributes->merge([
    'class' => "flex flex-col items-center gap-1 $baseClass hover:underline hover:underline-offset-4 transition text-sm whitespace-nowrap"
]) }}>
    {{ $slot }}
</a>
