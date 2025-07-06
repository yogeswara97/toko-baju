<a
    {{ $attributes }}
    class="{{ $active ? 'text-white bg-gray-800' : 'text-gray-900 hover:bg-gray-100' }} flex items-center p-2 rounded-lg"
>
    <i class="{{ $icon }}"></i>
    <span class="flex-1 ms-3 whitespace-nowrap">{{ $slot }}</span>
    @if($badge === 'true')
        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">{{ $count }}</span>
    @endif
</a>
