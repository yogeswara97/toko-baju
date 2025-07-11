<nav class="bg-white fixed top-0 w-full h-16 z-20 border-b border-gray-200">
    <div class="flex items-center justify-end mx-auto sm:px-10 h-full">
        <div class="flex items-center space-x-4 relative text-gray-800"> <!-- Ganti dari text-white -->

            <!-- Profile Dropdown Button -->
            <button type="button" class="flex items-center text-sm rounded-full focus:outline-none"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom-end">

                <!-- Profile Image -->
                <span class="h-9 w-9 rounded-full overflow-hidden">
                    <img class="w-full h-full object-cover rounded-full bg-gray-300 p-1"
                        src="{{ asset('assets/static-images/no-image.jpg') }}" alt="User Photo">
                </span>

                <!-- User Info -->
                <span class="ml-4 flex flex-col items-start leading-tight hidden sm:block">
                    <span class="text-sm font-semibold text-gray-800">
                        {{ session('user')['name'] ?? 'Guest' }}
                    </span>
                    <span class="text-xs text-gray-500 mt-0.5">
                        {{ session('user')['role'] == 'super.admin' ? 'Super Admin' : 'Admin' }}
                    </span>
                </span>

                <i class="fa fa-angle-down ml-3 text-gray-500 hidden sm:block"></i>
            </button>

            <!-- Dropdown Menu -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="z-50 hidden absolute right-0 top-full mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg"
                    id="user-dropdown">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="user-menu-button">
                        <li>
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                Sign out
                            </button>
                        </li>
                    </ul>
                </div>
            </form>
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
