@props([
    'dataset' => [],
    'placeholder' => 'Search by name',
    'name' => 'search',
])

<div class="w-full relative">
    <input type="text" id="simple-search" name="{{ $name }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-56 p-2.5"
        placeholder="{{ $placeholder }}" value="{{ request($name) }}" autocomplete="off">

    <div id="dropdown"
        class="hidden absolute z-10 bg-gray-100 divide-y divide-gray-100 rounded-b-lg shadow-sm w-56 max-h-32 overflow-y-scroll overflow-x-hidden">
        <ul class="py-2 text-sm text-gray-900" id="dropdownList">
            @foreach ($dataset as $item)
                <li>
                    <a href="#" class="dropdown-item block px-4 py-2 hover:bg-gray-200 font-semibold"
                        data-name="{{ $item }}">
                        {{ $item }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("simple-search");
            const dropdown = document.getElementById("dropdown");
            const dropdownItems = document.querySelectorAll(".dropdown-item");

            searchInput.addEventListener("click", () => {
                dropdown.classList.remove("hidden");
            });

            searchInput.addEventListener("input", () => {
                const filter = searchInput.value.toLowerCase();
                dropdownItems.forEach(item => {
                    const name = item.dataset.name.toLowerCase();
                    item.parentElement.style.display = name.includes(filter) ? 'block' : 'none';
                });
                dropdown.classList.remove("hidden");
            });

            document.addEventListener("click", (event) => {
                if (!dropdown.contains(event.target) && event.target !== searchInput) {
                    dropdown.classList.add("hidden");
                }
            });

            dropdownItems.forEach(item => {
                item.addEventListener("click", () => {
                    searchInput.value = item.dataset.name;
                    dropdown.classList.add("hidden");
                });
            });
        });
    </script>
@endpush
