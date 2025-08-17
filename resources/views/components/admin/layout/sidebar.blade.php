<!-- Your existing button and sidebar HTML -->
<button id="sidebar-toggle" data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar"
    aria-controls="default-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
    <span class="sr-only">Open sidebar</span>
    <i class="fas fa-bars w-6 h-6"></i>
</button>

<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen bg-admin-primary border-r border-gray-200 dark:border-gray-700 transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full flex flex-col px-4 py-6 overflow-y-auto">
        <!-- Brand -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 mb-3">
            <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                <span class="uppercase">
                    {{ config('app.name') }}
                </span>
            </span>
        </a>

        <!-- Divider -->
        <hr class="border-gray-300 dark:border-gray-700 mb-6">

        <!-- Section Label -->
        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">MENU</div>

        <!-- Navigation -->
        <nav class="flex flex-col space-y-1 text-sm">
            <x-admin.layout.side-link href="{{ route('admin.dashboard') }}"
                :active="request()->routeIs('admin.dashboard')" icon="fas fa-tachometer-alt">
                Dashboard
            </x-admin.layout.side-link>

            <x-admin.layout.side-link href="{{ route('admin.products.index') }}"
                :active="request()->is('admin/products*')" icon="fas fa-box">
                Products
            </x-admin.layout.side-link>

            <x-admin.layout.side-link href="{{ route('admin.orders.index') }}" :active="request()->is('admin/orders*')"
                icon="fas fa-box">
                Orders
            </x-admin.layout.side-link>

            <!-- Tambahin menu lainnya di sini -->
        </nav>
        <!-- Section Label -->
        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">USERS</div>

        <!-- Navigation -->
        <nav class="flex flex-col space-y-1 text-sm">

            <x-admin.layout.side-link href="{{ route('admin.customers.index') }}"
                :active="request()->is('admin/customers*')" icon="fas fa-users">
                Customers
            </x-admin.layout.side-link>

            <x-admin.layout.side-link href="{{ route('admin.admin.index') }}" :active="request()->is('admin/admin*')"
                icon="fas fa-user-shield">
                Admin
            </x-admin.layout.side-link>

            <!-- Tambahin menu lainnya di sini -->
        </nav>




        <!-- Footer (optional) -->
        <div class="mt-auto pt-6 text-xs text-gray-400">
            © {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</aside>

<!-- JavaScript to toggle the sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('default-sidebar');

        sidebarToggle.addEventListener('click', function () {
            // Toggle the sidebar visibility
            sidebar.classList.toggle('-translate-x-full');
        });
    });
</script>
