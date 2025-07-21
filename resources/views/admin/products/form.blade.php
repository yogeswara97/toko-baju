<x-admin.layout.layout :title="$product ? 'Edit Product' : 'Create Product'">

    <x-admin.layout.header :title="$product ? 'Edit Product' : 'Add Product'" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => $product ? 'Edit Product' : 'Add Product'],
    ]" />

    <div class="wrapper">

        <form method="POST"
            action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}"
            enctype="multipart/form-data" class="space-y-8">
            @csrf
            @if ($product)
                @method('PUT')
            @endif

            {{-- === BASIC INFO === --}}
            {{-- IMAGE UPLOAD WITH PREVIEW --}}
            <div class="space-y-2">
                <label for="image" class="block font-semibold">Main Product Image</label>
                <div class="flex items-center gap-4">
                    {{-- Preview --}}
                    <div
                        class="w-32 h-50 rounded border border-dashed border-gray-300 flex items-center justify-center bg-gray-100 overflow-hidden">
                        <img id="image-preview"
                            src="{{ !empty($product->image) ? asset('storage/' . $product->image) : asset('assets/static-images/no-image.jpg') }}"
                            alt="Preview" class="w-full h-full object-cover" />
                    </div>

                    {{-- File Input --}}
                    <div class="flex-1">
                        <input type="file" name="image" id="image"
                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Recommended: square image, max 2MB</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NAME --}}
                <div>
                    <label for="name" class="block mb-1 font-semibold">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}"
                        class="input" required>
                </div>

                {{-- CATEGORY --}}
                <div>
                    <label for="category_id" class="block mb-1 font-semibold">Category</label>
                    <select name="category_id" id="category_id" class="select" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(
                                old('category_id', $product->category_id ?? '') ==
                                $category->id
                            )>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PRICE --}}
                <div>
                    <label for="price" class="block mb-1 font-semibold">Price</label>
                    <input type="number" name="price" id="price" step="0.01"
                        value="{{ old('price', $product->price ?? '') }}" class="input" required>
                </div>

                {{-- TOGGLES --}}
                <div class="flex flex-col md:flex-row gap-4 mt-2">
                    {{-- Is Active --}}
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" class="sr-only peer" {{ old(
    'is_active',
    $product->is_active ?? true
) ? 'checked' : '' }}>
                        <div class="toggle-switch"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
                    </label>

                    {{-- Is Stock --}}
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_stock" class="sr-only peer" {{ old(
    'is_stock',
    $product->is_stock ?? true
) ? 'checked' : '' }}>
                        <div class="toggle-switch"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Stock</span>
                    </label>
                </div>


            </div>

            {{-- === DESCRIPTION + IMAGE === --}}
            <div class="grid grid-cols-1  gap-6">
                {{-- DESCRIPTION --}}
                <div>
                    <label for="description" class="block mb-1 font-semibold">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="input">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>

            {{-- === PRODUCT VARIANTS === --}}
            <div>
                <h3 class="text-lg font-bold mb-4">Product Variants</h3>
                <div id="variant-wrapper" class="space-y-6">
                    @php
                        $variants = old('variants', $product->variants ?? []);
                    @endphp

                    @foreach ($variants as $index => $variant)
                        <div
                            class="p-4 bg-gray-50 border border-gray-200 rounded-md shadow-sm grid grid-cols-1 md:grid-cols-5 gap-4 items-end variant-item">
                            {{-- Image Upload with Preview (Variant) - NEW STYLE --}}
                            <div class="md:col-span-1">
                                <label class="block font-semibold mb-1">Image</label>
                                <div class="flex items-center gap-4">
                                    {{-- Preview Box --}}
                                    <div
                                        class="w-24 h-38 rounded border border-dashed border-gray-300 flex items-center justify-center bg-gray-100 overflow-hidden">
                                        <img id="variant-preview-{{ $index }}"
                                            src="{{ !empty($variant->image) ? asset($variant->image) : asset('assets/static-images/no-image.jpg') }}"
                                            alt="Preview" class="w-full h-full object-cover" />
                                    </div>

                                    {{-- File Input --}}
                                    <div class="flex-1">
                                        <input type="file" name="variants[{{ $index }}][image]"
                                            class="file-input variant-image-input"
                                            data-preview-id="variant-preview-{{ $index }}" accept="image/*">
                                        <p class="text-xs text-gray-500 mt-1">Max 2MB</p>
                                    </div>
                                </div>
                            </div>


                            {{-- Color --}}
                            <div>
                                <label class="block mb-1 font-semibold">Color</label>
                                <select name="variants[{{ $index }}][color_id]" class="select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}" @selected(
                                            (isset($variant['product_color_id']) &&
                                                $variant['product_color_id'] == $color->id) || (isset($variant['color_id']) &&
                                                $variant['color_id'] == $color->id) || old("variants.$index.color_id") ==
                                            $color->id
                                        )>
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Size --}}
                            <div>
                                <label class="block mb-1 font-semibold">Size</label>
                                <select name="variants[{{ $index }}][size_id]" class="select">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}" @selected(
                                            (isset($variant['product_size_id']) &&
                                                $variant['product_size_id'] == $size->id) || (isset($variant['size_id']) &&
                                                $variant['size_id'] == $size->id) || old("variants.$index.size_id") == $size->id
                                        )>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Qty --}}
                            <div>
                                <label class="block mb-1 font-semibold">Qty</label>
                                <input type="number" name="variants[{{ $index }}][qty]" class="input"
                                    value="{{ $variant->qty ?? old(" variants.$index.qty") }}">
                            </div>

                            {{-- Price --}}
                            <div>
                                <label class="block mb-1 font-semibold">Price (optional)</label>
                                <input type="number" step="0.01" name="variants[{{ $index }}][price]" class="input"
                                    value="{{ $variant->price ?? old(" variants.$index.price") }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="button" id="add-variant"
                        class="bg-gray-200 hover:bg-gray-300 text-sm px-3 py-1 rounded shadow">
                        + Add Variant
                    </button>
                </div>
            </div>

            {{-- === ACTION BUTTONS === --}}
            <div class="flex justify-end gap-4 border-t border-gray-200 pt-6 mt-6">
                <a href="{{ route('admin.products.index') }}" class="button-back">Cancel</a>
                <button type="submit" class="button-submit">
                    {{ $product ? 'Update' : 'Save' }}
                </button>
            </div>
        </form>
    </div>

    {{-- === SCRIPT PREVIEW === --}}
    @push('scripts')
        <script>
            // Main Product Image Preview
            document.getElementById('image')?.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const preview = document.getElementById('image-preview');
                    preview.src = URL.createObjectURL(file);
                    preview.onload = () => URL.revokeObjectURL(preview.src);
                }
            });

            // Add Variant Button
            document.getElementById('add-variant').addEventListener('click', () => {
                const wrapper = document.getElementById('variant-wrapper');
                const index = wrapper.children.length;
                const colors = @json($colors);
                const sizes = @json($sizes);

                const variant = document.createElement('div');
                variant.className =
                    "p-4 bg-gray-50 border border-gray-200 rounded-md shadow-sm grid grid-cols-1 md:grid-cols-5 gap-4 items-end variant-item";

                variant.innerHTML = `
                <div class="md:col-span-1">
                    <label class="block font-semibold mb-1">Image</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-38 rounded border border-dashed border-gray-300 flex items-center justify-center bg-gray-100 overflow-hidden">
                            <img id="variant-preview-${index}" src="{{ asset('assets/static-images/no-image.jpg') }}" alt="Preview" class="w-full h-full object-cover" />
                        </div>
                        <div class="flex-1">
                            <input type="file" name="variants[${index}][image]" accept="image/*"
                                class="file-input variant-image-input"
                                data-preview-id="variant-preview-${index}">
                            <p class="text-xs text-gray-500 mt-1">Max 2MB</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Color</label>
                    <select name="variants[${index}][color_id]" class="select" required>
                        <option value="">-- Pilih --</option>
                        ${colors.map(c => `<option value="${c.id}">${c.name}</option>`).join('')}
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Size</label>
                    <select name="variants[${index}][size_id]" class="select">
                        <option value="">-- Pilih --</option>
                        ${sizes.map(s => `<option value="${s.id}">${s.name}</option>`).join('')}
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Qty</label>
                    <input type="number" name="variants[${index}][qty]" class="input">
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Price (optional)</label>
                    <input type="number" step="0.01" name="variants[${index}][price]" class="input">
                </div>
            `;
                wrapper.appendChild(variant);
            });

            // Dynamic Image Preview for All Variant Images
            document.addEventListener('change', function (e) {
                if (e.target.matches('.variant-image-input')) {
                    const file = e.target.files[0];
                    const previewId = e.target.getAttribute('data-preview-id');
                    if (file && previewId) {
                        const preview = document.getElementById(previewId);
                        preview.src = URL.createObjectURL(file);
                        preview.onload = () => URL.revokeObjectURL(preview.src);
                    }
                }
            });
        </script>
    @endpush

</x-admin.layout.layout>
