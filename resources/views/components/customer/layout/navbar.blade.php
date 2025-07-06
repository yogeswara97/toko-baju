{{-- resources/views/components/navbar.blade.php --}}
<div class="h-20 container-custom relative z-40 bg-white">
    {{-- Mobile Navbar --}}
    <div class="h-full flex items-center justify-between md:hidden">
        <a href="{{ route('home') }}" class="text-2xl tracking-wide font-medium">StyleHub</a>
        <button id="menu-toggle" class="md:hidden">
            <img src="{{ asset('assets/images/navbar/menu.png') }}" alt="menu" class="w-7 h-7">
        </button>
    </div>

    {{-- Desktop Navbar --}}
    <div class="hidden md:flex items-center justify-between gap-8 h-full">
        {{-- LEFT --}}
        <div class="w-1/3 xl:w-1/2 flex items-center gap-12">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/navbar/logo.png') }}" alt="logo" class="w-6 h-6">
                <div class="text-2xl tracking-wide font-medium">StyleHub</div>
            </a>
            <div class="hidden xl:flex gap-4">
                <x-customer.layout.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home
                </x-customer.layout.nav-link>
                <x-customer.layout.nav-link href="{{ route('customer.products.index') }}"
                    :active="request()->routeIs('customer.products.index')">Shop</x-customer.layout.nav-link>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="w-2/3 xl:w-1/2 flex items-center justify-between gap-8">
            {{-- SearchBar --}}
            <form method="GET" action="{{ route('customer.products.index') }}"
                class="flex items-center bg-gray-100 p-2 rounded-lg flex-1 gap-2 ">
                <input type="text" name="name" placeholder="Search" class="flex-1 bg-transparent outline-none text-sm rounded-lg">
                <button type="submit">
                    <img src="{{ asset('assets/images/navbar/search.png') }}" alt="search" class="w-4 h-4">
                </button>
            </form>

            {{-- NavIcons --}}
            <div class="flex items-center gap-4 xl:gap-6 relative">
                @if(auth()->check())
                {{-- Profile --}}
                <div class="relative">
                    <img src="{{ asset('assets/images/navbar/profile.png') }}" alt="profile"
                        class="w-6 h-6 cursor-pointer" id="profile-icon">
                    <div id="profile-dropdown"
                        class="hidden absolute top-10 left-0 p-4 bg-white rounded-md shadow-md text-sm z-20">
                        <x-customer.layout.nav-link href="{{ route('profile') }}">Profile</x-customer.layout.nav-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="mt-2 text-left w-full">Logout</button>
                        </form>
                    </div>
                </div>

                {{-- Cart --}}
                <a href="{{ route('customer.cart.index') }}" class="relative">
                    <img src="{{ asset('assets/images/navbar/cart.png') }}" alt="cart" class="w-6 h-6">
                    <div
                        class="absolute -top-2 -right-2 w-5 h-5 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center">
                        {{ session('cart_count', 0) }}
                    </div>
                </a>
                @else
                {{-- Belum login --}}
                <a href="{{ route('login') }}"
                    class="px-4 py-2 rounded-md  bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                    Sign Up
                </a>
                @endif
            </div>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu"
        class="hidden absolute left-0 top-20 w-full h-[calc(100vh-80px)] bg-white text-gray-800 z-40 shadow-md px-6 py-10 flex-col items-center gap-6 text-lg transition-all duration-300 ease-in-out md:hidden">
        <x-customer.layout.nav-link href="{{ route('home') }}">Homepage</x-customer.layout.nav-link>
        <x-customer.layout.nav-link href="{{ route('customer.products.index') }}">Shop</x-customer.layout.nav-link>
        <x-customer.layout.nav-link href="{{ route('customer.cart.index') }}">Cart</x-customer.layout.nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-600 hover:underline">Logout</button>
        </form>
    </div>


</div>

@push('scripts')
<script>
    document.getElementById('menu-toggle').addEventListener('click', () => {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    const profileIcon = document.getElementById('profile-icon');
    const profileDropdown = document.getElementById('profile-dropdown');

    profileIcon?.addEventListener('click', () => {
        profileDropdown.classList.toggle('hidden');
    });
</script>
@endpush
