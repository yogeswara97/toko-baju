<!-- Your existing button and sidebar HTML -->
<button id="sidebar-toggle" data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
    <span class="sr-only">Open sidebar</span>
    <i class="fas fa-bars w-6 h-6"></i>
</button>

<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 xl:w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 border border-gray-200 ">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="" class="flex items-center space-x-3 rtl:space-x-reverse mb-4">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-gray-900">Admin Bali Baci</span>
                </a>
            </li>
            <hr>
            <li>
                <div class="flex items-center py-2 text-gray-500 rounded-l">
                    <span class="ms-2">MENU</span>
                </div>
            </li>
            <li>
                <x-admin.layout.side-link href="{{ route('admin.dashboard') }}" :active="request()->is('/')" icon="fas fa-tachometer-alt" badge="false">Dashboard</x-admin.layout.side-link>
            </li>
        </ul>
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
