@props([
    'dataset' => [],
    'routeReset' => null,
    'routeCreate' => null,
    'create' => 'Create',
])

<div class="flex flex-col xl:flex-row xl:items-center justify-between space-y-3 md:space-y-0 md:space-x-2 p-4 gap-0">
    <div class="w-full">
        <form class="flex flex-col lg:flex-row lg:items-center gap-3">
            {{ $slot }}
            <x-admin.table.table-search :dataset="$dataset" />
            <button type="submit" class="button-submit">
                Filter
            </button>
        </form>
    </div>

    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-2 flex-shrink-0">
        @if ($routeReset)
            <a href="{{ $routeReset }}" class="button-delete">
                Reset Filter
            </a>
        @endif

        @if ($routeCreate)
            <a href="{{ $routeCreate }}" class="button-add">
                {{ $create }}
            </a>
        @endif
    </div>
</div>
