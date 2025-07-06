<x-customer.layout.layout>

    <section class="container-custom">
        <x-customer.page-header title="All Products" description="Discover our complete collection" />

        <!-- Filters and Products -->
        <div class="pb-8">
            <div class="flex flex-col gap-8">
                <!-- Filters Topbar -->
                <form method="GET" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Products</h3>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Category -->
                        <div>
                            <h4 class="font-medium mb-2 text-sm text-gray-700">Category</h4>
                            <div class="flex flex-col gap-2 max-h-48 overflow-auto pr-1">
                                @foreach($categories as $category)
                                <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                                    <input type="checkbox" name="category[]" value="{{ $category->slug }}"
                                        class="mr-2 accent-blue-600" {{ in_array($category->slug,
                                    request()->get('category', [])) ? 'checked' : '' }}>
                                    {{ $category->name }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Sort + Size -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Sort -->
                            <div>
                                <h4 class="font-medium mb-2 text-sm text-gray-700">Sort By</h4>
                                <select name="sort"
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-blue-500">
                                    <option value="">Featured</option>
                                    <option value="price_low" {{ request('sort')=='price_low' ? 'selected' : '' }}>
                                        Price: Low to High</option>
                                    <option value="price_high" {{ request('sort')=='price_high' ? 'selected' : '' }}>
                                        Price: High to Low</option>
                                    <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Newest
                                    </option>
                                </select>
                            </div>

                            <!-- Size -->
                            <div>
                                <h4 class="font-medium mb-2 text-sm text-gray-700">Size</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($sizes as $size)
                                    @php
                                    $selectedSizes = request()->get('size', []);
                                    $isActive = in_array($size->id, $selectedSizes);
                                    @endphp
                                    <label
                                        class="px-2 py-1 border rounded text-xs cursor-pointer transition
                        {{ $isActive ? 'bg-blue-100 border-blue-500 text-blue-700' : 'border-gray-300 hover:bg-gray-100 text-gray-600' }}">
                                        <input type="checkbox" name="size[]" value="{{ $size->id }}" class="hidden" {{
                                            $isActive ? 'checked' : '' }}>
                                        {{ $size->name }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Color + Buttons -->
                        <div class="flex flex-col gap-4 justify-between h-full">
                            <!-- Color -->
                            <div>
                                <h4 class="font-medium mb-2 text-sm text-gray-700">Color</h4>
                                <div class="flex flex-wrap gap-3 items-center">
                                    @foreach ($colors as $color)
                                    @php
                                    $selectedColors = request()->get('color', []);
                                    $isChecked = in_array($color->id, $selectedColors);
                                    @endphp
                                    <label class="flex items-center space-x-2 text-xs cursor-pointer">
                                        <input type="checkbox" name="color[]" value="{{ $color->id }}"
                                            class="accent-blue-600" {{ $isChecked ? 'checked' : '' }}>
                                        <div class="w-5 h-5 rounded-full border shadow-sm"
                                            style="background-color: {{ $color->hex_code }}"></div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Apply / Reset -->
                            <div class="mt-4 flex gap-3">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition w-full">
                                    Apply Filters
                                </button>
                                <a href="{{ route('customer.products.index') }}"
                                    class="text-sm text-blue-600 hover:underline flex items-center justify-center w-full">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>




                <div class="">
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-gray-600"><span id="product-count">{{ $products->total() }}</span> products found
                        </p>
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="products-grid">
                        @foreach ($products as $product)
                        <x-customer.product-card :slug="$product->slug" :image="$product->image" :name="$product->name"
                            :description="Str::limit($product->description, 60)" :price="$product->price" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-12">
                        <nav class="flex space-x-2">
                            <button class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-100">Previous</button>
                            <button class="px-3 py-2 bg-blue-600 text-white rounded">1</button>
                            <button class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-100">2</button>
                            <button class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-100">3</button>
                            <button class="px-3 py-2 border border-gray-300 rounded hover:bg-gray-100">Next</button>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const sizeLabels = document.querySelectorAll('label input[name="size[]"]');

        sizeLabels.forEach(input => {
            input.addEventListener('change', () => {
                const label = input.parentElement;
                if (input.checked) {
                    label.classList.add('bg-blue-100', 'border-blue-500', 'text-blue-700');
                    label.classList.remove('border-gray-300', 'hover:bg-gray-100');
                } else {
                    label.classList.remove('bg-blue-100', 'border-blue-500', 'text-blue-700');
                    label.classList.add('border-gray-300', 'hover:bg-gray-100');
                }
            });
        });
    });
    </script>
    @endpush
</x-customer.layout.layout>
<!-- Products Grid -->
