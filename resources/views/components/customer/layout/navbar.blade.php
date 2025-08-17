<nav class="{{ !request()->routeIs('customer.home') ? 'bg-transparent' : 'bg-primary' }}">
    <div class="h-20 container-custom relative z-40  text-secondary text-sm font-medium">


        {{-- Desktop Navbar --}}
        <div class="hidden lg:flex items-center justify-between h-full px-4 sm:px-6 lg:px-0 relative">

            {{-- LEFT: Product Categories --}}
            <div class="flex gap-4 sm:gap-6 overflow-x-auto">
                <x-customer.layout.nav-link href="{{ route('customer.home') }}">Home</x-customer.layout.nav-link>
                <x-customer.layout.nav-link href="{{ route('customer.products.index') }}">All Products
                </x-customer.layout.nav-link>
                @foreach ($navbarCategories as $category)
                    <x-customer.layout.nav-link
                        href="{{ route('customer.products.index', ['category[]' => $category->slug]) }}">
                        {{ $category->name }}
                    </x-customer.layout.nav-link>
                @endforeach

            </div>

            {{-- CENTER: Brand Title --}}
            @if (!request()->routeIs('customer.home'))
                <div class="absolute left-1/2 -translate-x-1/2">
                    <a href="{{ route('customer.home') }}"
                        class="text-4xl font-extrabold tracking-tighter text-primary uppercase">
                        {{ config('app.name') }}
                    </a>
                </div>
            @endif

            {{-- RIGHT: Icons --}}
            @php
                $iconClass = request()->routeIs('customer.home') ? 'text-secondary' : 'text-gray-700';
            @endphp

            <div class="flex items-center gap-4 shrink-0">
                @if (auth()->check())
                    {{-- User Profile --}}
                    <a href="{{ route('customer.profile.index') }}" class="hover:text-gray-700 transition {{ $iconClass }}">
                        <i class="fas fa-user"></i>
                    </a>

                    {{-- Cart --}}
                    <a href="{{ route('customer.cart.index') }}"
                        class="relative hover:text-gray-700 transition {{ $iconClass }}">
                        <i class="fas fa-shopping-bag"></i>
                        @if ($cartCount > 0)
                            <div @class([
                                'absolute -top-2 -right-2 w-4 h-4 text-[10px] rounded-full flex items-center justify-center',
                                'bg-primary-light text-black' => request()->routeIs('customer.home'),
                                'bg-primary text-white' => !request()->routeIs('customer.home'),
                            ])>
                            {{ $cartCount }}
                            </div>
                        @endif
                    </a>
                    {{-- Admin Panel (only for admin/super.admin) --}}
                    @if (in_array(auth()->user()->role, ['admin', 'super.admin']))
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-2 rounded-md text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800 transition">
                            Admin Panel
                        </a>
                    @endif
                @else
                    {{-- Login --}}
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-md bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
                        Login
                    </a>
                @endif
            </div>



        </div>


        {{-- Mobile Navbar --}}
        <div class="h-full flex items-center justify-between lg:hidden px-1 py-2">
            {{-- App Name --}}
            <div>
                @if (!request()->routeIs('customer.home'))
                    <a href="{{ route('customer.home') }}"
                        class="text-4xl tracking-widest font-semibold uppercase text-primary">
                        {{ config('app.name') ?: 'MyStore' }}
                    </a>
                @endif
            </div>

            {{-- Hamburger Button --}}
            <button id="menu-toggle"
                class="{{ request()->routeIs('customer.home') ? 'text-white' : 'text-black' }} text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>


        {{-- Mobile Overlay + Menu --}}
        {{-- 🔹 Blur Background Overlay --}}
        <div id="mobile-overlay"
            class="fixed inset-0 z-30 bg-white/30 backdrop-blur-md hidden transition-opacity duration-300"></div>

        {{-- 🔹 Mobile Menu (From Top Navbar) --}}
        <div id="mobile-menu"
            class="lg:hidden invisible opacity-0 -translate-y-full transition-all duration-300 ease-out
flex flex-col gap-4 px-4 py-6 bg-white text-black fixed top-0 left-0 right-0 z-50 shadow-md rounded-b-xl overflow-y-auto">


            {{-- NAV LINK --}}
            <x-customer.layout.nav-link href="{{ route('customer.home') }}">Home</x-customer.layout.nav-link>
            <x-customer.layout.nav-link href="{{ route('customer.products.index') }}">All Products
            </x-customer.layout.nav-link>

            @foreach ($navbarCategories as $category)
                <x-customer.layout.nav-link
                    href="{{ route('customer.products.index', ['category[]' => $category->slug]) }}">
                    {{ $category->name }}
                </x-customer.layout.nav-link>
            @endforeach

            {{-- USER / LOGIN --}}
            <div class="flex items-center gap-4 mt-4">
                @if (auth()->check())
                    {{-- <a href="#"><i class="fas fa-search"></i></a> --}}
                    <a href="{{ route('customer.profile.index') }}"><i class="fas fa-user"></i></a>
                    <a href="{{ route('customer.cart.index') }}" class="relative">
                        <i class="fas fa-shopping-bag"></i>
                        @if ($cartCount > 0)
                            <div
                                class="absolute -top-2 -right-2 w-4 h-4 bg-primary text-white text-[10px] rounded-full flex items-center justify-center">
                                {{ $cartCount }}
                            </div>
                        @endif

                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-md bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
                        Login
                    </a>
                @endif
            </div>
        </div>



    </div>

    @push('scripts')
        <script>
            const toggleBtn = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileOverlay = document.getElementById('mobile-overlay');

            toggleBtn.addEventListener('click', () => {
                const isVisible = !mobileMenu.classList.contains('invisible');

                if (isVisible) {
                    // Hide
                    mobileMenu.classList.add('opacity-0', '-translate-y-full');
                    mobileMenu.classList.remove('opacity-100', 'translate-y-0');
                    mobileOverlay.classList.add('opacity-0');
                    setTimeout(() => {
                        mobileMenu.classList.add('invisible');
                        mobileOverlay.classList.add('hidden');
                    }, 300);
                } else {
                    // Show
                    mobileMenu.classList.remove('invisible');
                    mobileOverlay.classList.remove('hidden');
                    setTimeout(() => {
                        mobileMenu.classList.remove('opacity-0', '-translate-y-full');
                        mobileMenu.classList.add('opacity-100', 'translate-y-0');

                        mobileOverlay.classList.remove('opacity-0');
                    }, 10);
                }
            });

            // Hide when click outside (overlay)
            mobileOverlay.addEventListener('click', () => {
                mobileMenu.classList.add('opacity-0', '-translate-y-10');
                mobileMenu.classList.remove('opacity-100', 'translate-y-0');
                mobileOverlay.classList.add('opacity-0');
                setTimeout(() => {
                    mobileMenu.classList.add('invisible');
                    mobileOverlay.classList.add('hidden');
                }, 300);
            });
        </script>
    @endpush



</nav>
