<header class="bg-white shadow-md h-16 flex items-center justify-between px-4 lg:px-6 sticky top-0 z-50">
    <div class="flex items-center">
        <!-- Mobile hamburger menu -->
        <button id="sidebar-toggle" class="lg:hidden mr-4 text-gray-600 hover:text-gray-800 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
    </div>
    
    <div class="flex items-center space-x-2 lg:space-x-4">
        <!-- Search - hidden on small screens -->
        <div class="relative hidden md:block">
            <input type="text" placeholder="Search..." class="border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-red-500 w-48 lg:w-64">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        
        <!-- Mobile search icon -->
        <button class="md:hidden text-gray-500 hover:text-gray-700">
            <i class="fas fa-search text-lg"></i>
        </button>
        
        <div class="relative">
            <i class="fas fa-bell text-gray-500 cursor-pointer text-lg lg:text-xl"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 lg:w-5 lg:h-5 flex items-center justify-center text-xs">3</span>
        </div>
        <div class="relative group">
            <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-red-500 flex items-center justify-center text-white font-semibold text-sm cursor-pointer">
                AD
            </div>
            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <div class="py-2">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800">Admin</p>
                        <p class="text-xs text-gray-500">admin@nocis.id</p>
                    </div>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i>Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </a>
                    <div class="border-t border-gray-100 mt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>