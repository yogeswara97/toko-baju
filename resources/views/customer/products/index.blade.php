<x-customer.layout.layout>

    <section class="container-custom">
        <x-customer.page-header title="All Products" description="Discover our complete collection" />

        <!-- Filters and Products -->
        <div class="pb-8">
            <div class="flex flex-col gap-8">
                <!-- Filters Topbar -->
                <form method="GET" class="bg-primary text-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-6">Filter Products</h3>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Category -->
                        <div class="flex flex-col gap-4">
                            <div>
                                <h4 class="text-sm font-medium mb-2">Category</h4>
                                <div class="flex flex-col gap-2 max-h-48 overflow-auto pr-1">
                                    @foreach($categories as $category)
                                    <label class="flex items-center text-sm cursor-pointer">
                                        <input type="checkbox" name="category[]" value="{{ $category->slug }}"
                                            class="mr-2 accent-white bg-white/10 border-white/30 rounded" {{
                                            in_array($category->slug, request()->get('category', [])) ? 'checked' : ''
                                        }}>
                                        {{ $category->name }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sort & Size -->
                        <div class="flex flex-col gap-6">
                            <!-- Sort -->
                            <div>
                                <h4 class="text-sm font-medium mb-2">Sort By</h4>
                                <select name="sort"
                                    class="w-full bg-white/10 text-white border border-white/30 rounded px-3 py-2 text-sm focus:ring-white appearance-none">
                                    <option class="bg-primary text-white" value="">Featured</option>
                                    <option class="bg-primary text-white" value="price_low" {{
                                        request('sort')=='price_low' ? 'selected' : '' }}>
                                        Price: Low to High
                                    </option>
                                    <option class="bg-primary text-white" value="price_high" {{
                                        request('sort')=='price_high' ? 'selected' : '' }}>
                                        Price: High to Low
                                    </option>
                                    <option class="bg-primary text-white" value="newest" {{ request('sort')=='newest'
                                        ? 'selected' : '' }}>
                                        Newest
                                    </option>
                                </select>
                            </div>

                            <!-- Size -->
                            <div>
                                <h4 class="text-sm font-medium mb-2">Size</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($sizes as $size)
                                    @php
                                    $selectedSizes = request()->get('size', []);
                                    $isChecked = in_array($size->id, $selectedSizes);
                                    @endphp

                                    <label class="relative">
                                        <input type="checkbox" name="size[]" value="{{ $size->id }}"
                                            class="sr-only peer" {{ $isChecked ? 'checked' : '' }}>
                                        <div
                                            class="peer-checked:bg-white peer-checked:text-primary peer-checked:font-semibold
                text-white text-xs border border-white/30 rounded px-4 py-1.5 cursor-pointer transition-all duration-200 hover:bg-white/10">
                                            {{ $size->name }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Color & Buttons -->
                        <div class="flex flex-col justify-between gap-6">
                            <!-- Color -->
                            <div>
                                <h4 class="text-sm font-medium mb-2">Color</h4>
                                <div class="flex flex-wrap gap-3 items-center">
                                    @foreach ($colors as $color)
                                    @php
                                    $selectedColors = request()->get('color', []);
                                    $isChecked = in_array($color->id, $selectedColors);
                                    @endphp
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="color[]" value="{{ $color->id }}"
                                            class="sr-only peer" {{ $isChecked ? 'checked' : '' }}>
                                        <div class="w-7 h-7 rounded-full border border-gray-400 peer-checked:scale-110 peer-checked:ring-2 peer-checked:ring-offset-1 peer-checked:ring-white/80 transition-all duration-300"
                                            style="background-color: {{ $color->hex_code }};">
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Apply & Reset Buttons -->
                            <div class="mt-2 flex flex-col sm:flex-row gap-3">
                                <button type="submit"
                                    class="bg-white text-primary px-4 py-2 rounded text-sm hover:bg-gray-100 font-semibold w-full sm:w-1/2">
                                    Apply Filters
                                </button>
                                <a href="{{ route('customer.products.index') }}"
                                    class="text-sm underline flex items-center justify-center w-full sm:w-1/2 hover:text-white/90">
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
                            <button class="px-3 py-2 bg-primary text-white rounded">1</button>
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
