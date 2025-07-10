<x-customer.layout.layout>
    <div class="bg-primary flex flex-col">

        <!-- Hero -->
        <div class="bg-primary min-h-[calc(100vh-4rem)] flex flex-col">
            <section class="relative flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 overflow-hidden">
                <!-- Judul -->
                <h1
                    class="absolute top-0 text-white font-bold text-[5rem] md:text-[10rem] xl:text-[14rem] tracking-tight z-0 leading-none text-center w-full opacity-80 drop-shadow-lg uppercase">
                    {{ config('app.name') }}
                </h1>
                <h1
                    class="absolute top-30 md:top-60 text-white font-bold text-[1rem] md:text-[2rem] xl:text-[3rem] tracking-tight z-0 leading-none text-center w-full opacity-80 drop-shadow-lg">
                    Elevate your everyday look
                </h1>


                <!-- Gradient bawah -->
                <div
                    class="absolute bottom-0 left-0 w-full h-[40%] bg-gradient-to-t from-prbg-primary to-transparent z-10">
                </div>

                <!-- Button -->
                <div
                    class="absolute z-20 text-white drop-shadow-lg flex flex-col items-center gap-4 top-[80%] w-full text-center">

                    <a href="{{ route('customer.products.index') }}"
                        class="w-3/4 sm:w-60 md:w-70 px-6 py-3 bg-black text-white text-sm font-semibold tracking-wide shadow-lg rounded-md hover:bg-white hover:text-black transition-all duration-300">
                        Shop Now
                    </a>

                </div>


                <!-- Gambar -->
                <img src="{{ asset('assets/static-images/hero_no_bg.png') }}" alt="Man Sitting"
                    class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-6xl h-[600px] md:h-[90vh] object-cover xl:object-contain z-10" />
            </section>
        </div>
    </div>


    {{-- Shirts Section --}}
    @php
        $categories = [
            [
                'title' => 'MEN’S ESSENTIALS: SHIRTS, TEES & POLOS',
                'desc' => 'Upgrade your wardrobe with timeless pieces for every occasion. From sleek polos to comfy tees — find your fit and stay effortlessly cool, all day every day.',
                'image' => asset('assets/static-images/category/man.png'),
                'alt' => 'Shirts',
                'reverse' => false,
                'textAlign' => 'lg:text-right',
                'slug' => 'men'
            ],
            [
                'title' => 'FOR HER: BLOUSES, TOPS & CHIC TEES',
                'desc' => 'Style made simple. Dive into our curated picks of modern blouses, everyday tops, and trend-forward tees that fit every mood — from classy to casual.',
                'image' => asset('assets/static-images/category/women.png'),
                'alt' => 'Blouses',
                'reverse' => true,
                'textAlign' => 'lg:text-left',
                'slug' => 'women'
            ],
            [
                'title' => 'BAGS, HATS & ALL THE EXTRAS',
                'desc' => 'Top off your look with must-have accessories. From statement bags to everyday hats — it’s the little things that make the biggest style impact.',
                'image' => asset('assets/static-images/category/accessories.jpg'),
                'alt' => 'Accessories',
                'reverse' => false,
                'textAlign' => 'lg:text-right',
                'slug' => 'accessories'
            ],
        ];
    @endphp


    <section class="container-custom mx-auto lg:px-10 py-20 flex flex-col space-y-20">
        @foreach ($categories as $cat)
            <div class="flex flex-col {{ $cat['reverse'] ? 'lg:flex-row-reverse' : 'lg:flex-row' }} gap-10">
                <!-- Gambar -->
                <div class="w-full lg:w-1/2">
                    <div class="max-w-[500px] w-full mx-auto lg:mx-0">
                        <img src="{{ $cat['image'] }}" alt="{{ $cat['alt'] }}"
                            class="w-full h-auto object-cover shadow-lg" />
                    </div>
                </div>

                <!-- Teks -->
                <!-- Teks -->
                <div class="w-full lg:w-1/2 mt-10 lg:mt-0 text-center {{ $cat['textAlign'] }}">
                    <h2 class="text-3xl sm:text-4xl md:text-8xl font-black tracking-tight leading-tight">
                        {!! nl2br(e($cat['title'])) !!}
                    </h2>
                    <p class="mt-6 text-gray-700 text-lg sm:text-xl">
                        {{ $cat['desc'] }}
                    </p>

                    <a href="{{ route('customer.products.index', ['category[]' => $cat['slug']]) }}"
                        class="inline-block mt-6 px-6 py-3 bg-primary text-white text-sm font-semibold rounded-md shadow hover:bg-primary-dark transition">
                        Shop Now
                    </a>
                </div>

            </div>
        @endforeach
    </section>



</x-customer.layout.layout>
