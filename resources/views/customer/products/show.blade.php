<x-customer.layout.layout>
    <section class="container-custom py-10 relative flex flex-col lg:flex-row gap-16">
        {{-- Gambar Produk --}}
        <div class="w-full lg:w-1/2 lg:sticky top-20 h-max">
            <div class="h-[500px] relative">
                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover rounded-md">
            </div>
        </div>

        {{-- Info Produk --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-6">
            {{-- Error dari server --}}
            @if ($errors->any())
                <div class="text-red-600 text-sm mb-2 bg-red-100 px-4 py-2 rounded-md">
                    {{ $errors->first() }}
                </div>
            @endif

            <h1 class="text-4xl font-medium text-gray-900">{{ $product->name }}</h1>
            <p class="text-gray-500">{{ $product->description }}</p>
            <hr class="h-[1.5px] bg-gray-200 border-0">

            <div class="text-2xl font-semibold text-pink-600">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            {{-- Size Options --}}
            @if ($sizes->isNotEmpty())
                <div>
                    <label class="block font-medium mb-2">Ukuran:</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($sizes as $size)
                            <button type="button"
                                class="size-btn px-4 py-2 border rounded-lg text-sm transition border-gray-300 hover:bg-blue-100"
                                data-size-id="{{ $size->id }}">
                                {{ $size->name }}
                            </button>
                        @endforeach
                    </div>
                    <p id="size-error" class="text-red-500 text-sm mt-1 hidden">Pilih ukuran dulu ya 🤏</p>
                </div>
                <hr class="h-[1.5px] bg-gray-200 border-0">
            @endif

            {{-- Color Options --}}
            @if ($colors->isNotEmpty())
                <div id="color-section">
                    <label class="block font-medium mb-2">Warna:</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($colors as $color)
                            <div class="color-btn relative group cursor-pointer" data-color-id="{{ $color->id }}">
                                <div class="color-circle w-8 h-8 rounded-full border-2"
                                    style="background-color: {{ $color->hex_code ?? '#ccc' }};"></div>
                                <div
                                    class="slash hidden absolute inset-0 flex justify-center items-center text-red-600 text-xl font-bold pointer-events-none">
                                    /
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p id="color-error" class="text-red-500 text-sm mt-1 hidden">Warnanya juga pilih dong 🌈</p>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('customer.cart.store') }}" method="POST" id="add-to-cart-form"
                class="flex flex-col gap-4 mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size_id" id="selected-size-id">
                <input type="hidden" name="color_id" id="selected-color-id">
                <input type="hidden" name="qty" id="qty" value="{{ $quantity ?? 1 }}">

                <div>
                    <h4 class="font-medium mb-1">Jumlah</h4>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 py-2 px-4 rounded-3xl flex items-center justify-between w-32">
                                <button type="button" class="text-xl" onclick="updateQuantity('decrement')">-</button>
                                <span id="quantity-display">{{ $quantity ?? 1 }}</span>
                                <button type="button" class="text-xl" onclick="updateQuantity('increment')">+</button>
                            </div>
                            <div class="text-sm">
                                Tersisa <span class="text-orange-500">{{ $stockNumber ?? 10 }}</span> item<br>
                                Buruan sebelum kehabisan!
                            </div>
                        </div>
                        <button type="submit"
                            class="w-36 text-sm rounded-3xl bg-pink-500 text-white py-2 px-4 hover:bg-pink-600 transition disabled:cursor-not-allowed disabled:bg-pink-200"
                            @if(($stockNumber ?? 10) <= 0) disabled @endif>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- Produk Terkait --}}
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Produk Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @for ($i = 0; $i < 4; $i++)
                    <x-customer.product-card slug="produk-terkait-{{ $i }}"
                        image="https://source.unsplash.com/featured/?fashion,clothes&sig={{ $i + 30 }}"
                        name="Produk Terkait {{ $i + 1 }}" description="Produk lainnya yang mungkin kamu suka."
                        :price="rand(150, 350) * 1000" />
                @endfor
            </div>
        </div>
    </section>

    {{-- Scripts --}}
    @push('scripts')
    <script>
        const hasSizes = {{ $sizes->isNotEmpty() ? 'true' : 'false' }};
        const hasColors = {{ $colors->isNotEmpty() ? 'true' : 'false' }};

        const form = document.getElementById('add-to-cart-form');
        const sizeButtons = document.querySelectorAll('.size-btn');
        const colorButtons = document.querySelectorAll('.color-btn');
        const sizeInput = document.getElementById('selected-size-id');
        const colorInput = document.getElementById('selected-color-id');

        let selectedSize = null;
        let selectedColor = null;

        // --- Update colors based on selected size
        const variants = @json($variants);
        function updateColorsBySize() {
            const colorSection = document.getElementById('color-section');
            if (!selectedSize) {
                colorButtons.forEach(btn => {
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    btn.querySelector('.slash').classList.remove('hidden');
                    btn.setAttribute('data-disabled', 'true');
                });
                return;
            }

            const availableColors = variants.filter(v => v.size_id == selectedSize).map(v => v.color_id);
            colorButtons.forEach(btn => {
                const cid = parseInt(btn.dataset.colorId);
                const isAvailable = availableColors.includes(cid);

                btn.classList.toggle('opacity-50', !isAvailable);
                btn.classList.toggle('cursor-not-allowed', !isAvailable);
                btn.querySelector('.slash').classList.toggle('hidden', isAvailable);
                btn.setAttribute('data-disabled', isAvailable ? 'false' : 'true');
            });
        }

        // --- Size button event
        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                selectedSize = btn.dataset.sizeId;
                sizeInput.value = selectedSize;

                sizeButtons.forEach(b => b.classList.remove('bg-blue-100', 'text-blue-700'));
                btn.classList.add('bg-blue-100', 'text-blue-700');

                selectedColor = null;
                colorInput.value = '';
                document.getElementById('size-error')?.classList.add('hidden');

                updateColorsBySize();
            });
        });

        // --- Color button event
        colorButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.dataset.disabled === 'true') return;

                colorButtons.forEach(b => b.classList.remove('ring-2', 'ring-pink-500'));
                btn.classList.add('ring-2', 'ring-pink-500');

                selectedColor = btn.dataset.colorId;
                colorInput.value = selectedColor;
                document.getElementById('color-error')?.classList.add('hidden');
            });
        });

        // --- Form submit
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

        // --- Quantity handler
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

        document.addEventListener('DOMContentLoaded', updateColorsBySize);
    </script>
    @endpush
</x-customer.layout.layout>
