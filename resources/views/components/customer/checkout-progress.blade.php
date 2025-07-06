@props([
    'steps' => ['Cart', 'Checkout', 'Payment'],
    'current' => 1,
])

<div class=" py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center space-x-4">
            @foreach ($steps as $index => $step)
                @php
                    $stepNumber = $index + 1;
                    $isActive = $stepNumber <= $current;
                    $isLast = $loop->last;
                @endphp

                <div class="flex items-center">
                    <div
                        class="w-8 h-8 {{ $isActive ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}
                            rounded-full flex items-center justify-center text-sm font-semibold">
                        {{ $stepNumber }}
                    </div>
                    <span class="ml-2 text-sm font-medium {{ $isActive ? 'text-blue-600' : 'text-gray-600' }}">
                        {{ $step }}
                    </span>
                </div>

                @unless($isLast)
                    <div class="w-16 h-1 {{ $stepNumber < $current ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
                @endunless
            @endforeach
        </div>
    </div>
</div>
