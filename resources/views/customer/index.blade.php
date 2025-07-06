<x-customer.layout.layout>

    <!-- Hero Section -->
    <section class="relative h-[calc(100vh-80px)] overflow-hidden">
        <div x-data="{ current: 0, slides: {{ json_encode($slides) }} }"
            x-init="setInterval(() => { current = (current + 1) % slides.length }, 5000)"
            class="w-max h-full flex transition-all duration-700 ease-in-out"
            :style="'transform: translateX(-' + (current * 100) + 'vw)'">

            <template x-for="(slide, index) in slides" :key="slide.id">
                <div class="w-screen h-full flex flex-col gap-16 xl:flex-row" :class="slide.bg">
                    <!-- Text Container -->
                    <div class="h-1/2 xl:w-1/2 xl:h-full flex flex-col items-center justify-center gap-8 text-center">
                        <h2 class="text-xl lg:text-3xl" x-text="slide.description"></h2>
                        <h1 class="text-5xl lg:text-6xl font-semibold" x-text="slide.title"></h1>
                        <a :href="slide.url" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">SHOP
                            NOW</a>
                    </div>

                    <!-- Image Container -->
                    <div class="h-1/2 xl:w-1/2 xl:h-full relative">
                        <img :src="slide.img" alt="" class="w-full h-full object-cover" />
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <div @click="current = index"
                    class="w-3 h-3 rounded-full border border-gray-600 cursor-pointer flex items-center justify-center"
                    :class="{ 'scale-150 bg-gray-600': current === index }">
                </div>
            </template>
        </div>
    </section>




</x-customer.layout.layout>
