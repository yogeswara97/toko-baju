<div class="flex flex-wrap items-center justify-between mb-4">
    <div class="flex gap-4 items-center">
        <h2 class="text-xl font-semibold text-gray-900">{{ $title }}</h2>
        <h2 class="text-xl font-normal text-gray-900">{{ $slot }}</h2>
    </div>

    @unless (empty($breadcrumbs))
    <nav class="flex mr-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            @foreach ($breadcrumbs as $index => $breadcrumb)
            <li>
                <div class="flex items-center">
                    @if ($index > 0)
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    @endif

                    @if (!empty($breadcrumb['url']))
                    <a href="{{ $breadcrumb['url'] }}"
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-gray-400 md:ms-2">
                        {{ $breadcrumb['label'] }}
                    </a>
                    @else
                    <span class="ms-1 text-sm font-semibold text-gray-900 md:ms-2">
                        {{ $breadcrumb['label'] }}
                    </span>
                    @endif
                </div>
            </li>
            @endforeach

        </ol>
    </nav>
    @endunless
</div>
