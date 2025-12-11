<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'NOCIS - National Olympic Committee of Indonesia')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Job-specific CSS -->
    <style>
        .job-card {
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }

        .status-open {
            background-color: #D6F5E5;
            color: #22C55E;
        }

        .status-closed {
            background-color: #FEE2E2;
            color: #EF4444;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #F59E0B;
        }
    </style>

    <!-- Meta Tags -->
    <meta name="description" content="NOCIS Job Opportunities - Find exciting career opportunities at major sporting events">
    <meta name="keywords" content="NOCIS, jobs, career, sports, olympics, Indonesia">
    <meta name="author" content="NOCIS">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="NOCIS Job Opportunities">
    <meta property="og:description" content="Find exciting career opportunities at major sporting events">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header - Landing Page Style -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/Logo NOA Indonesia.png') }}" alt="NOC Indonesia Logo" class="h-10 w-auto">
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900">NOCIS</h1>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">National Olympic Committee</p>
                    </div>
                </div>

                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('jobs.index') }}" class="text-primary font-medium border-b-2 border-primary pb-1">Jobs</a>
                    @if(session('customer_authenticated'))
                        <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-primary transition-colors">Dashboard</a>
                    @endif
                </nav>
                <div class="flex items-center space-x-3">
                    @if(session('customer_authenticated'))
                        <!-- Customer Profile Dropdown -->
                        <div class="relative group">
                            <a href="{{ route('customer.profile') }}" class="block">
                                <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center text-white font-semibold text-sm cursor-pointer hover:bg-red-600 transition-colors">
                                    {{ strtoupper(substr(session('customer_username') ?? 'U', 0, 2)) }}
                                </div>
                            </a>
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-gray-800">{{ session('customer_username') ?? 'Customer' }}</p>
                                        <p class="text-xs text-gray-500">{{ session('customer_email') ?? 'user@email.com' }}</p>
                                    </div>
                                    <div class="border-t border-gray-100 mt-1">
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="{{ route('customer.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
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
                    @else
                        <a href="{{ route('login') }}" class="bg-[#ef4444] text-white px-4 py-2 rounded-md font-medium hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-[#ef4444] px-4 py-2 rounded-md font-medium hover:bg-[#fef2f2] transition-colors border border-[#ef4444]">
                            <i class="fas fa-user-plus mr-2"></i>
                            Sign Up
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden text-gray-600 hover:text-primary">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4 border-t border-gray-100">
                <nav class="flex flex-col space-y-3">
                    <a href="{{ route('jobs.index') }}" class="text-primary font-medium">Jobs</a>
                    @if(session('customer_authenticated'))
                        <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-primary transition-colors">Dashboard</a>
                        <div class="border-t border-gray-100 pt-3 mt-3">
                            <div class="flex items-center space-x-3 px-3 py-2">
                                <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white font-semibold text-xs">
                                    {{ strtoupper(substr(session('customer_username') ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ session('customer_username') ?? 'Customer' }}</p>
                                    <p class="text-xs text-gray-500">{{ session('customer_email') ?? 'user@email.com' }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    @elseif(session('admin_authenticated') && session('admin_role') === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-primary transition-colors">Admin Panel</a>
                        <span class="text-gray-700 font-medium text-sm">Welcome, {{ session('admin_username') ?? 'Admin' }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md font-medium transition-colors border border-gray-300 w-full">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-center bg-[#ef4444] text-white px-4 py-2 rounded-md font-medium hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="block text-center bg-white text-[#ef4444] px-4 py-2 rounded-md font-medium hover:bg-[#fef2f2] transition-colors border border-[#ef4444]">
                            <i class="fas fa-user-plus mr-2"></i>
                            Sign Up
                        </a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer - Landing Page Style -->
    <footer class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand Section -->
                <div class="lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/Logo NOA Indonesia.png') }}" alt="NOC Indonesia Logo" class="h-12 w-auto">
                        <div class="ml-3">
                            <h1 class="text-xl font-bold text-gray-900">NOCIS</h1>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">National Olympic Committee</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-6">
                        Transforming Olympic management with cutting-edge technology and seamless operations.
                    </p>
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" class="bg-[#ef4444] text-white px-4 py-2 rounded-lg font-medium inline-flex items-center justify-center shadow-lg hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                            <i class="fas fa-rocket mr-2"></i>
                            Get Started
                        </a>
                        <a href="{{ route('jobs.index') }}" class="bg-white/20 backdrop-blur-sm border border-white/30 text-gray-800 px-5 py-2 rounded-lg hover:bg-white/30 transition-colors font-medium inline-flex items-center justify-center">
                            <i class="fas fa-briefcase mr-2"></i>
                            Browse Jobs
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('jobs.index') }}" class="text-gray-600 hover:text-primary transition-colors">Job Openings</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">About NOCIS</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Events Calendar</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Career Tips</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Resources</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">FAQ & Help</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Connect & Newsletter -->
                <div>
                    <h3 class="font-bold text-lg text-gray-900 mb-4">Connect With Us</h3>
                    <div class="flex space-x-3 mb-6">
                        <a href="#" class="text-gray-600 hover:text-primary transition-colors"><i class="fab fa-facebook-f text-lg"></i></a>
                        <a href="#" class="text-gray-600 hover:text-primary transition-colors"><i class="fab fa-twitter text-lg"></i></a>
                        <a href="#" class="text-gray-600 hover:text-primary transition-colors"><i class="fab fa-instagram text-lg"></i></a>
                        <a href="#" class="text-gray-600 hover:text-primary transition-colors"><i class="fab fa-linkedin-in text-lg"></i></a>
                    </div>

                    <h4 class="font-semibold text-gray-800 mb-3">Newsletter</h4>
                    <p class="text-sm text-gray-600 mb-3">Get the latest job opportunities delivered to your inbox</p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Your email address"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-2 rounded-lg font-medium transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-200 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-500 mb-4 md:mb-0">
                    &copy; {{ date('Y') }} National Olympic Committee of Indonesia. All rights reserved.
                </div>
                <div class="flex space-x-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-primary transition-colors">Privacy</a>
                    <a href="#" class="hover:text-primary transition-colors">Terms</a>
                    <a href="#" class="hover:text-primary transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Flash Messages -->
    @include('components.flash')

    <!-- Scripts -->
    <script src="{{ asset('js/jobs.js') }}"></script>
    <script>
        // Initialize all functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Mobile filter toggle
            const filterToggle = document.getElementById('filter-toggle');
            const filterSidebar = document.getElementById('filter-sidebar');
            const filterOverlay = document.getElementById('filter-overlay');
            const closeFilterBtn = document.getElementById('close-filter');

            if (filterToggle && filterSidebar && filterOverlay && closeFilterBtn) {
                filterToggle.addEventListener('click', function() {
                    filterSidebar.classList.add('open');
                    filterOverlay.classList.add('active');
                });

                closeFilterBtn.addEventListener('click', function() {
                    filterSidebar.classList.remove('open');
                    filterOverlay.classList.remove('active');
                });

                filterOverlay.addEventListener('click', function() {
                    filterSidebar.classList.remove('open');
                    filterOverlay.classList.remove('active');
                });
            }

            // Job card hover effects
            const jobCards = document.querySelectorAll('.job-card');
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                });
            });
        });
    </script>
</body>
</html>