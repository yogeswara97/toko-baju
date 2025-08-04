@props([
    'href',
    'active' => false,
    'icon' => '',
])

@php
$classes = $active
    ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-semibold'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white';
@endphp

<a href="{{ $href }}" class="flex items-center px-3 py-2 rounded-lg transition-colors {{ $classes }}">
    <i class="{{ $icon }} text-sm w-5"></i>
    <span class="ml-3">{{ $slot }}</span>
</a>
