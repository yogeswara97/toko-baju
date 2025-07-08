<nav class="{{ !request()->routeIs('home') ? 'bg-transparent' : 'bg-primary' }}">
    <div class="h-20 container-custom relative z-40  text-secondary text-sm font-medium">
        {{-- Mobile Navbar --}}
        <div class="h-full flex items-center justify-between md:hidden px-4">
            <a href="{{ route('home') }}" class="text-2xl tracking-widest font-semibold">StyleHub</a>
            <button id="menu-toggle" class="md:hidden">
                <img src="{{ asset('assets/images/navbar/menu.png') }}" alt="menu" class="w-7 h-7">
            </button>
        </div>

        {{-- Desktop Navbar --}}
        <div class="hidden md:flex items-center justify-between h-full px-4 sm:px-6 lg:px-0 relative">

            {{-- LEFT: Product Categories --}}
            <div class="flex gap-4 sm:gap-6 overflow-x-auto">
                <x-customer.layout.nav-link href="{{ route('home') }}">Home</x-customer.layout.nav-link>
                <x-customer.layout.nav-link href="{{ route('customer.products.index') }}">Products
                </x-customer.layout.nav-link>
            </div>

            {{-- CENTER: Brand Title --}}
            <div class="absolute left-1/2 -translate-x-1/2">
                <a href="{{ route('home') }}" class="text-4xl font-extrabold tracking-tighter text-primary">
                    STYLEHUB
                </a>
            </div>

            {{-- RIGHT: Icons --}}
            @php
            $iconClass = request()->routeIs('home') ? 'text-secondary' : 'text-gray-700';
            @endphp

            <div class="flex items-center gap-4 shrink-0">
                <a href="#" class="hover:text-gray-700 transition {{ $iconClass }}">
                    <i class="fas fa-search"></i>
                </a>
                <a href="{{ route('customer.profile') }}" class="hover:text-gray-700 transition {{ $iconClass }}">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ route('customer.cart.index') }}"
                    class="relative hover:text-gray-700 transition {{ $iconClass }}">
                    <i class="fas fa-shopping-bag"></i>
                    <div
                        class="absolute -top-2 -right-2 w-4 h-4 bg-primary text-white text-[10px] rounded-full flex items-center justify-center">
                        {{ session('cart_count', 0) }}
                    </div>
                </a>
            </div>

        </div>


        {{-- Mobile Menu --}}
        <div id="mobile-menu"
            class="hidden absolute left-0 top-20 w-full h-[calc(100vh-80px)] bg-white text-gray-800 z-40 shadow-md px-6 py-10 flex-col items-center gap-6 text-lg transition-all duration-300 ease-in-out md:hidden">
            <x-customer.layout.nav-link href="#">Shirts & Tops</x-customer.layout.nav-link>
            <x-customer.layout.nav-link href="#">Outerwear</x-customer.layout.nav-link>
            <x-customer.layout.nav-link href="#">Bottoms</x-customer.layout.nav-link>
            <x-customer.layout.nav-link href="#">Caps</x-customer.layout.nav-link>
            <x-customer.layout.nav-link href="{{ route('customer.cart.index') }}">Cart</x-customer.layout.nav-link>
        </div>
    </div>
</nav>
