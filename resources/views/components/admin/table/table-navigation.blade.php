<nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4" aria-label="Table navigation">
    <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">
        Showing <span class="font-semibold text-gray-900">{{ ($dataset->currentPage() - 1) * $perPage + 1 }}</span> to
        <span class="font-semibold text-gray-900">{{ min($dataset->currentPage() * $perPage, $dataset->total()) }}</span>
        of <span class="font-semibold text-gray-900">{{ $dataset->total() }}</span>
    </span>
    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
        @if ($dataset->onFirstPage())
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg cursor-not-allowed">Previous</a>
            </li>
        @else
            <li>
                <a href="{{ $dataset->previousPageUrl() }}"
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
            </li>
        @endif

        @foreach ($dataset->getUrlRange(1, $dataset->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}"
                    class="flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 hover:bg-gray-100 hover:text-gray-700 {{ $page == $dataset->currentPage() ? 'z-10 text-white bg-gray-800' : 'bg-white text-gray-500' }}">{{ $page }}</a>
            </li>
        @endforeach

        @if ($dataset->hasMorePages())
            <li>
                <a href="{{ $dataset->nextPageUrl() }}"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
            </li>
        @else
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed">Next</a>
            </li>
        @endif
    </ul>


</nav>
