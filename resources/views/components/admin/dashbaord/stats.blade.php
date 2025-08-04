@props(['label', 'value', 'change', 'color' => 'green', 'icon' => 'up'])

@php
    $colors = [
        'green' => 'text-green-500',
        'red' => 'text-red-500',
        'yellow' => 'text-yellow-500',
        'blue' => 'text-blue-500',
    ];
    $svgUp = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />';
    $svgDown = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />';
@endphp

<div class="bg-white p-6 rounded-lg shadow-sm">
    <h4 class="text-gray-500 text-sm font-medium">{{ $label }}</h4>
    <div class="flex justify-between items-end mt-2">
        <p class="text-3xl font-bold text-gray-800">{{ $value }}</p>
        <div class="flex items-center space-x-1 text-sm font-semibold {{ $colors[$color] ?? 'text-green-500' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                {!! $icon === 'up' ? $svgUp : $svgDown !!}
            </svg>
            <span>{{ $change }}</span>
            <span class="text-gray-400 font-normal text-xs">vs last 7 days</span>
        </div>
    </div>
</div>
