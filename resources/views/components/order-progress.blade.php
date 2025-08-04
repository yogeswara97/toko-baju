@props([
    'number' => 1,
    'label' => '',
    'active' => false,
    'completed' => false,
    'color' => 'gray',
])

@php
    $state = $completed ? 'completed' : ($active ? 'active' : 'default');

    $colorMap = [
        'requested' => [
            'completed' => ['bg' => 'bg-slate-500 text-white', 'text' => 'text-slate-600'],
            'active'    => ['bg' => 'bg-slate-100 text-slate-600 border border-slate-500', 'text' => 'text-slate-600'],
            'default'   => ['bg' => 'bg-gray-300 text-white', 'text' => 'text-gray-400'],
        ],
        'picked_up' => [
            'completed' => ['bg' => 'bg-blue-500 text-white', 'text' => 'text-blue-600'],
            'active'    => ['bg' => 'bg-blue-100 text-blue-600 border border-blue-500', 'text' => 'text-blue-600'],
            'default'   => ['bg' => 'bg-gray-300 text-white', 'text' => 'text-gray-400'],
        ],
        'in_transit' => [
            'completed' => ['bg' => 'bg-cyan-500 text-white', 'text' => 'text-cyan-600'],
            'active'    => ['bg' => 'bg-cyan-100 text-cyan-600 border border-cyan-500', 'text' => 'text-cyan-600'],
            'default'   => ['bg' => 'bg-gray-300 text-white', 'text' => 'text-gray-400'],
        ],
        'out_for_delivery' => [
            'completed' => ['bg' => 'bg-amber-500 text-white', 'text' => 'text-amber-600'],
            'active'    => ['bg' => 'bg-amber-100 text-amber-600 border border-amber-500', 'text' => 'text-amber-600'],
            'default'   => ['bg' => 'bg-gray-300 text-white', 'text' => 'text-gray-400'],
        ],
        'delivered' => [
            'completed' => ['bg' => 'bg-green-500 text-white', 'text' => 'text-green-600'],
            'active'    => ['bg' => 'bg-green-100 text-green-600 border border-green-500', 'text' => 'text-green-600'],
            'default'   => ['bg' => 'bg-gray-300 text-white', 'text' => 'text-gray-400'],
        ],
        'confirmed' => [
            'completed' => ['bg' => 'bg-emerald-500 text-white', 'text' => 'text-emerald-600'],
            'active'    => ['bg' => 'bg-emerald-100 text-emerald-600 border border-emerald-500', 'text' => 'text-emerald-600'],
            'default'   => ['bg' => 'bg-gray-300 text-white', 'text' => 'text-gray-400'],
        ],
    ];

    $bgClass = $colorMap[$color][$state]['bg'] ?? 'bg-gray-300 text-white';
    $textClass = $colorMap[$color][$state]['text'] ?? 'text-gray-400';
@endphp

<div class="flex items-center">
    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $bgClass }}">
        {{ $number }}
    </div>
    <span class="ml-2 text-sm font-medium {{ $textClass }}">
        {{ $label }}
    </span>
</div>
