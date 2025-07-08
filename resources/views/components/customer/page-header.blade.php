@props([
    'title',
    'description' => null,
])

<div class="py-8">
    <div class="">
        <h1 class="text-6xl font-medium text-gray-900">{{ $title }}</h1>

        @if ($description)
            <p class="text-xl text-gray-600 mt-2">{{ $description }}</p>
        @endif
    </div>
</div>
