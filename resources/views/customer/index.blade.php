<x-customer.layout.layout>
    <div class="bg-primary flex flex-col">

        <!-- Hero -->
        <div class="bg-primary min-h-[calc(100vh-4rem)] flex flex-col">
            <section class="relative flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 overflow-hidden">
                <!-- Judul -->
                <h1
                    class="absolute top-0 text-white font-bold text-[5rem] md:text-[10rem] xl:text-[14rem] tracking-tight z-0 leading-none text-center w-full opacity-80 drop-shadow-lg">
                    STYLEHUB
                </h1>
                <h1
                    class="absolute top-30 md:top-60 text-white font-bold text-[1rem] md:text-[2rem] xl:text-[3rem] tracking-tight z-0 leading-none text-center w-full opacity-80 drop-shadow-lg">
                    Elevate your everyday look
                </h1>


                <!-- Gradient bawah -->
                <div
                    class="absolute bottom-0 left-0 w-full h-[40%] bg-gradient-to-t from-prbg-primary to-transparent z-10">
                </div>

                <!-- Slogan & Button -->
                <div
                    class="absolute z-20 text-white drop-shadow-lg flex flex-col items-center gap-4 top-[80%] w-full text-center ">

                    <a href="#"
                        class="px-6 py-3 bg-white text-black text-sm font-medium rounded-full shadow-lg hover:bg-black hover:text-white transition-all duration-300">
                        Shop Now
                    </a>
                </div>

                <!-- Gambar -->
                <img src="{{ asset('assets/static-images/hero_no_bg.png') }}" alt="Man Sitting"
                    class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-6xl h-[600px] md:h-[90vh] object-cover z-10" />
            </section>
        </div>
    </div>



    {{-- Shirts Section --}}
    <section class="container-custom mx-auto  lg:px-10 py-20 flex flex-col ">
        <div class="flex gap-20">
            <!-- Gambar -->
            <div class="flex justify-between w-1/2">
                <div class="max-w-[500px] w-full">
                    <img src="{{ asset('assets/static-images/category/man.png') }}" alt="Shirts"
                        class="w-full h-auto object-cover shadow-lg" />
                </div>
            </div>

            <!-- Teks -->
            <div class="text-center md:text-right w-1/2 mt-10">
                <h2 class="text-3xl sm:text-4xl md:text-9xl font-black tracking-tight">
                    SHIRTS, T-SHIRTS & POLO SHIRTS
                </h2>
                <p class="mt-6 text-gray-100 md:text-gray-700 text-xl">
                    Explore our versatile collection of shirts, t-shirts, and polo shirts.
                    Whether you’re going for a classic, casual, or sporty look,
                    we’ve got you covered with the latest styles and best fits.
                </p>
            </div>
        </div>
        <div class="flex gap-20">
            <!-- Teks -->
            <div class="text-center md:text-left w-1/2 mt-10">
                <h2 class="text-3xl sm:text-4xl md:text-9xl font-black tracking-tight">
                    BLOUSES, TOPS<br />& CHIC TEE STYLES
                </h2>
                <p class="mt-6 text-gray-100 md:text-gray-700 text-xl">
                    Discover our latest picks of blouses, casual tops, and chic tees for every mood.
                    From elegant staples to laid-back weekend vibes — express your style your way.
                </p>
            </div>
            <!-- Gambar -->
            <div class="flex justify-between w-1/2">
                <div class="max-w-[500px] w-full">
                    <img src="{{ asset('assets/static-images/category/women.png') }}" alt="Shirts"
                        class="w-full h-auto object-cover  shadow-lg" />
                </div>
            </div>


        </div>
    </section>

</x-customer.layout.layout>
