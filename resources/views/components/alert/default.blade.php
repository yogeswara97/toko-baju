{{-- @if ($errors->any())
<div x-data="{ show: true }" x-show="show"
    class=" relative p-4  border border-red-300 bg-red-50 text-red-800 rounded shadow-sm transition-all duration-300">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button @click="show = false" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif --}}


@if ($errors->any())
<div class="bg-red-100 text-red-700 px-4 py-3 rounded border border-red-300 mb-6">
    <strong class="font-semibold">Ada kesalahan!</strong>
    <ul class="mt-2 list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
