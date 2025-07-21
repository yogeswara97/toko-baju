<nav class="bg-white fixed top-0 w-full h-16 z-20 border-b border-gray-200">
    <div class="flex items-center justify-end mx-auto sm:px-10 h-full">
        <div class="flex items-center space-x-4 relative text-gray-800">
            <!-- Ganti dari text-white -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('customer.home') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-admin-secondary hover:bg-blue-700 rounded-md transition">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
            </div>
            <!-- Profile Dropdown Button -->
            <button type="button"
                class="flex items-center gap-3 sm:gap-4 px-2 py-1 sm:px-3 sm:py-2 rounded-full hover:bg-gray-100 cursor-pointer"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom-end">

                <!-- Profile Image -->
                <div class="h-9 w-9 rounded-full overflow-hidden border border-gray-300 shadow-sm bg-white">
                    <img class="w-full h-full object-cover"
                        src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('assets/static-images/no-image.jpg') }}"
                        alt="User Photo">
                </div>

                <!-- User Info -->
                <div class="hidden sm:flex flex-col items-start leading-tight">
                    <span class="text-sm font-medium text-gray-900">
                        {{ session('user')['name'] ?? 'Guest' }}
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ session('user')['role'] == 'super.admin' ? 'Super Admin' : 'Admin' }}
                    </span>
                </div>

                <!-- Dropdown Icon -->
                <i class="fa fa-angle-down text-gray-500 text-sm hidden sm:inline-block"></i>
            </button>


            <!-- Dropdown Menu -->
            <div class="z-50 hidden absolute right-0 top-full mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-xl"
                id="user-dropdown">
                <!-- Header Profile -->
                <div class="px-4 py-4 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                            <img class="w-full h-full object-cover"
                                src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('assets/static-images/no-image.jpg') }}"
                                alt="Profile Picture">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-800">
                                {{ auth()->user()->name ?? 'Guest' }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ auth()->user()->email ?? '-' }}
                            </span>
                            <span class="text-xs text-gray-400 mt-1">
                                Role: {{ optional(session('user'))['role'] == 'super.admin' ? 'Super Admin' : 'Admin' }}
                            </span>
                            <span class="text-xs text-gray-400">
                                Joined: {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="{{ route('admin.profile.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fas fa-user mr-2 text-gray-500"></i> Profile
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            userMenuButton.addEventListener('click', function (e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            window.addEventListener('click', function (e) {
                if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</nav>
