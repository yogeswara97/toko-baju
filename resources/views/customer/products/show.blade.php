<x-customer.layout.layout>


    <section class="container-custom ">
        <x-alert.default />
        <section class="py-8 md:py-12">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

                <img id="main-product-image" src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                    class="w-full max-w-md mx-auto object-cover rounded-xl shadow-md">

                <div>
                    <h1 class="text-right text-gray-800 text-6xl mb-4 tracking-tighter fontse">{{ $product->name }}
                    </h1>

                    <p class="text-sm text-gray-600 mb-4">
                        {{ $product->description }}
                    </p>


                    @if ($sizes->filter()->isNotEmpty())
                    <hr class="my-6 border-gray-300">
                    <div class="mb-3">
                        <p class="text-lg font-semibold text-gray-800 mb-3">Product Sizes</p>
                        <div class="flex space-x-2 mb-2">
                            @foreach ($sizes->filter() as $size)
                            <button
                                class="size-btn border border-gray-400 text-gray-800 font-bold py-2 px-5 hover:bg-gray-200"
                                data-size-id="{{ $size->id }}">{{ $size->name }}</button>
                            @endforeach
                        </div>
                        <p id="size-error" class="text-red-500 text-sm hidden">Pilih ukuran dulu ya 🤏</p>
                    </div>
                    @endif

                    @if ($colors->filter()->isNotEmpty())
                    <div id="color-section">
                        <p class="text-lg font-semibold text-gray-800 mb-3">Color</p>
                        <div class="flex flex-col space-x-2 mb-2">
                            <div class="flex flex-wrap gap-2 mb-2">
                                @foreach ($colors->filter() as $color)
                                <div class="color-btn relative group cursor-pointer" data-color-id="{{ $color->id }}">
                                    <div class="w-10 h-10 border-2 rounded-full"
                                        style="background-color: {{ $color->hex_code ?? '#ccc' }};">
                                    </div>
                                    <div
                                        class="slash hidden absolute inset-0 flex justify-center items-center pointer-events-none">
                                        <div class="w-full h-0.5 bg-red-600 rotate-45"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <p id="color-error" class="text-red-500 text-sm mt-1 hidden">Silahkan Pilih Warna</p>
                        </div>
                    </div>
                    @endif


                    <hr class="my-6 border-gray-300">

                    <div class="flex items-end space-x-3 mb-6">
                        {{-- <p class="text-gray-400 line-through text-2xl">$ 129.00</p> --}}
                        <p class="text-gray-800 font-bold text-4xl">Rp
                            {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <h4 class="font-medium mb-1 text-lg">Jumlah</h4>

                    <div class=" mb-6">
                        <div class="flex items-center gap-4">
                            {{-- Tombol - --}}
                            <button type="button" onclick="updateQuantity('decrement')"
                                class="w-10 h-10 border border-gray-300 text-xl font-bold flex items-center justify-center hover:bg-gray-200 transition">
                                -
                            </button>

                            {{-- Jumlah --}}
                            <div id="quantity-display"
                                class="w-12 h-10 border border-gray-300 text-center flex items-center justify-center text-lg font-medium">
                                {{ $quantity ?? 1 }}
                            </div>

                            {{-- Tombol + --}}
                            <button type="button" onclick="updateQuantity('increment')"
                                class="w-10 h-10 border border-gray-300 text-xl font-bold flex items-center justify-center hover:bg-gray-200 transition">
                                +
                            </button>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('customer.cart.store') }}" method="POST" id="add-to-cart-form"
                        class="flex flex-col gap-4 mt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}" readonly>
                        <input type="hidden" name="product_size_id" id="selected-size-id">
                        <input type="hidden" name="product_color_id" id="selected-color-id">
                        <input type="hidden" name="qty" id="qty" value="{{ $quantity ?? 1 }}">

                        <div>
                            <h4 class="font-medium mb-1">Jumlah</h4>
                            <div class="flex justify-between items-center">


                                <div class="flex items-center space-x-3 mb-2 w-full">
                                    <button class="border border-gray-400 p-3 hover:bg-gray-200">
                                        <i class="far fa-heart text-xl"></i>
                                    </button>
                                    <button type="submit"
                                        class="flex-1 bg-gray-800 text-white font-bold py-3 px-6 hover:bg-gray-700 text-center "
                                        @if (($stockNumber ?? 10) <=0) disabled @endif>Add
                                        to cart</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="text-xs text-gray-500">Delivery in 3-5 working days</p>
                </div>
            </div>
            <div>
                <x-customer.page-header title="More Products" description="Discover our complete collection" />
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="products-grid">
                    @foreach ($products as $product)
                    <x-customer.product-card :slug="$product->slug" :image="$product->image" :name="$product->name"
                        :description="Str::limit($product->description, 60)" :price="$product->price" />
                    @endforeach
                </div>
            </div>

            </div>
        </section>



        {{-- Scripts --}}
        @push('scripts')
        <script>
            const hasSizes = {{ $sizes->filter()->isNotEmpty() ? 'true' : 'false' }};
                const hasColors = {{ $colors->filter()->isNotEmpty() ? 'true' : 'false' }};

                const form = document.getElementById('add-to-cart-form');
                const sizeButtons = document.querySelectorAll('.size-btn');
                const colorButtons = document.querySelectorAll('.color-btn');
                const sizeInput = document.getElementById('selected-size-id');
                const colorInput = document.getElementById('selected-color-id');
                const imgEl = document.getElementById('main-product-image');

                let selectedSize = null;
                let selectedColor = null;

                const variants = @json($variants); // Format harus punya image, size_id, color_id
                // console.log(variants);

                // --- Update colors based on selected size
                function updateColorsBySize() {
                    if (!selectedSize) {
                        colorButtons.forEach(btn => {
                            btn.classList.add('opacity-50', 'cursor-not-allowed');
                            btn.querySelector('.slash').classList.remove('hidden');
                            btn.setAttribute('data-disabled', 'true');
                        });
                        return;
                    }

                    const availableColors = variants
                        .filter(v => v.size_id == selectedSize)
                        .map(v => v.color_id);

                    colorButtons.forEach(btn => {
                        const cid = parseInt(btn.dataset.colorId);
                        const isAvailable = availableColors.includes(cid);

                        btn.classList.toggle('opacity-50', !isAvailable);
                        btn.classList.toggle('cursor-not-allowed', !isAvailable);
                        btn.querySelector('.slash').classList.toggle('hidden', isAvailable);
                        btn.setAttribute('data-disabled', isAvailable ? 'false' : 'true');
                    });
                }

                // --- Update product image based on selected size & color
                function updateProductImage() {
                    if (!selectedSize || !selectedColor) return;

                    const variant = variants.find(v =>
                        v.size_id == selectedSize && v.color_id == selectedColor
                    );

                    if (variant && variant.image) {
                        imgEl.src = '/' + variant.image;
                    }
                }

                // --- Size button event
                sizeButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        selectedSize = btn.dataset.sizeId;
                        sizeInput.value = selectedSize;

                        sizeButtons.forEach(b => b.classList.remove('bg-blue-100', 'text-blue-700'));
                        btn.classList.add('bg-blue-100', 'text-blue-700');

                        // Reset color
                        colorButtons.forEach(b => b.classList.remove('ring-2', 'ring-red-500'));
                        selectedColor = null;
                        colorInput.value = '';

                        document.getElementById('size-error')?.classList.add('hidden');

                        updateColorsBySize();
                        updateProductImage();
                    });
                });

                // --- Color button event
                colorButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (btn.dataset.disabled === 'true') return;

                        colorButtons.forEach(b => b.classList.remove('ring-2', 'ring-red-500'));
                        btn.classList.add('ring-2', 'ring-red-500');

                        selectedColor = btn.dataset.colorId;
                        colorInput.value = selectedColor;

                        document.getElementById('color-error')?.classList.add('hidden');

                        updateProductImage();
                    });
                });

                // --- Form submit validation
                form.addEventListener('submit', e => {
                    let valid = true;

                    if (hasSizes && !sizeInput.value) {
                        document.getElementById('size-error')?.classList.remove('hidden');
                        valid = false;
                    }

                    if (hasColors && !colorInput.value) {
                        document.getElementById('color-error')?.classList.remove('hidden');
                        valid = false;
                    }

                    if (!valid) e.preventDefault();
                });

                // --- Quantity Handler
                function updateQuantity(action) {
                    const qtyInput = document.getElementById('qty');
                    const qtyDisplay = document.getElementById('quantity-display');
                    let qty = parseInt(qtyInput.value);
                    const stock = {{ $stockNumber ?? 10 }};

                    if (action === 'increment' && qty < stock) qty++;
                    else if (action === 'decrement' && qty > 1) qty--;

                    qtyInput.value = qty;
                    qtyDisplay.textContent = qty;
                }

                document.addEventListener('DOMContentLoaded', () => {
                    updateColorsBySize();
                });
        </script>
        @endpush

</x-customer.layout.layout>
