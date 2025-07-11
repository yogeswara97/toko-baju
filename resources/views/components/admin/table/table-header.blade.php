<div class="flex flex-col xl:flex-row xl:items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 gap-2">

    {{-- SEARCH --}}
    <div class="w-full ">
        <form class="flex flex-col lg:flex-row lg:items-center gap-3">
            {{ $slot }}
            <x-search :dataset="$dataset"></x-search>
            <button type="submit" class="button-submit">
                Filter
            </button>
        </form>
    </div>

    {{-- BUTTON --}}
    <div
        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
        <a href="{{ $routeReset }}" class="button-delete">
            Reset Filter
        </a>
        <a href="{{ $routeCreate }}" class="button-add">
            {{ $create }}
        </a>
    </div>
</div>

