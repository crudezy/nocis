<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="lg:hidden"></div>

<div class="main-sidebar sidebar-style-2 bg-white text-gray-700 shadow-lg" id="sidebar"> 
    <aside id="sidebar-wrapper">
        
        <div class="sidebar-brand p-4 border-b border-gray-200 relative">
            <div class="flex items-center justify-center">
                <a href="{{ url('dashboard') }}" class="flex items-center justify-center">
                    <img src="{{ asset('images/indonesia-olympic-logo.png') }}?v={{ time() }}" 
                         alt="Indonesia Olympic Committee" 
                         class="logo-img block">
                </a>
            </div>
            <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700 absolute top-4 right-4 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <ul class="sidebar-menu mt-8">
            
            {{-- Dashboard --}}
            <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-home mr-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Events (ACARA) --}}
            <li class="menu-item {{ Request::is('events*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/events') }}">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    <span>Event</span>
                </a>
            </li>
            
            {{-- Volunteers (SUKARELAWAN) --}}
            <li class="menu-item {{ Request::is('volunteers*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('volunteers') }}">
                    <i class="fas fa-users mr-3"></i>
                    <span>Volunteers</span>
                </a>
            </li>
            
            {{-- Reviews --}}
            <li class="menu-item {{ Request::is('reviews*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('reviews') }}">
                    <i class="fas fa-edit mr-3"></i>
                    <span>Reviews</span>
                </a>
            </li>

        </ul>
        
        <div class="sidebar-footer p-4 mt-auto">
             <div class="flex justify-around">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="w-3 h-3 rounded-full bg-pink-500"></span>
            </div>
        </div>
        
    </aside>
</div>