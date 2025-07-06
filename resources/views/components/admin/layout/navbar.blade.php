<nav class="bg-gray-50 border border-gray-200 fixed top-0 w-full h-16 z-20">
    <div class=" flex flex-wrap items-center justify-end mx-auto sm:px-10 py-4">
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse relative text-black">
            <button type="button"
                class="flex items-center text-sm rounded-full"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="h-9 w-9 rounded-full overflow-hidden">
                    <img class="w-full h-full object-cover rounded-full bg-gray-200 p-2" src="{{ asset('img/user2.png') }}"
                        alt="user photo">
                </span>
                <span class="ml-4 flex flex-col items-start">
                    <div class="block text-sm font-medium text-black ">
                        {{ session('user')['name'] }}
                    </div>
                    <div class="block text-xs text-gray-500">
                        {{ session('user')['role'] == 'super.admin' ? 'Super Admin' : 'Admin' }}
                    </div>
                </span>
                <i class="hidden sm:block ml-4 fa fa-angle-down text-gray-500"></i>
            </button>


            <!-- Dropdown menu -->
            <form action="{{ route('logout.post') }}" method="POST" style="display: inline;">
                @csrf
                <div class="z-50 hidden absolute right-5 sm:right-0 top-full mt-2 text-base list-none bg-gray-100 border border-gray-200 divide-y divide-gray-100 rounded-lg shadow-sm"
                    id="user-dropdown">
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Sign
                                out</button>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="submit"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 "
                    aria-controls="navbar-user" aria-expanded="false">
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.querySelector('[data-collapse-toggle="navbar-user"]');
        const navbar = document.getElementById('navbar-user');
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        // Toggle the main navbar
        toggleButton.addEventListener('click', function() {
            navbar.classList.toggle('hidden');
        });

        // Toggle the user dropdown menu
        userMenuButton.addEventListener('click', function() {
            userDropdown.classList.toggle('hidden');
        });

        // Close the dropdown if clicked outside
        window.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    });
</script>
