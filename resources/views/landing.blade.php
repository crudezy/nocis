
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'NOCIS - National Olympic Committee Information System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                @layer base {
                    html, :host {
                        --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                    }
                }
                @layer utilities {
                    .bg-nocis-primary { background-color: #1a365d; }
                    .bg-nocis-secondary { background-color: #2d3748; }
                    .text-nocis-primary { color: #1a365d; }
                    .text-nocis-secondary { color: #2d3748; }
                    .bg-nocis-accent { background-color: #3182ce; }
                    .text-nocis-accent { color: #3182ce; }
                    .hover\:bg-nocis-accent:hover { background-color: #2c5282; }
                    .border-nocis-accent { border-color: #3182ce; }
                    .bg-nocis-job { background-color: #f7fafc; }
                    .border-nocis-job { border-color: #e2e8f0; }
                    .bg-nocis-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
                    .text-nocis-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
                }
            </style>
        @endif

        <style>
            /* Modern UI Styles */
            :root {
                --primary: #3182ce;
                --primary-dark: #2c5282;
                --primary-light: #ebf8ff;
                --secondary: #1a365d;
                --accent: #667eea;
                --text-dark: #1a202c;
                --text-light: #4a5568;
                --border: #e2e8f0;
                --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                --red: #ef4444;
                --red-dark: #dc2626;
                --red-light: #fee2e2;
            }

            body {
                font-family: 'Inter', sans-serif;
            }

            .hero-gradient {
                background: linear-gradient(180deg, #ef4444 0%, #fca5a5 30%, #fef2f2 70%, #ffffff 100%);
                position: relative;
                overflow: hidden;
            }

            .hero-gradient::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></svg>');
                pointer-events: none;
            }

            .card-hover {
                transition: var(--transition);
                transform: translateY(0);
                box-shadow: var(--shadow);
            }

            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: var(--shadow-lg);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                transition: var(--transition);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px -5px rgba(49, 130, 206, 0.4);
            }

            .btn-red {
                background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
                transition: var(--transition);
            }

            .btn-red:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px -5px rgba(220, 38, 38, 0.4);
            }


            .job-badge {
                background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
                color: var(--primary);
            }

            .stats-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .floating-animation {
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(2deg); }
            }

            .pulse-animation {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: .8; }
            }

            .scroll-indicator {
                animation: bounce 2s infinite;
            }

            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }

            /* Glassmorphism Effect */
            .glass-effect {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-800">
        <!-- Header with Modern Design -->
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
                        <a href="#features" class="text-gray-600 hover:text-primary transition-colors font-medium">Features</a>
                        <a href="#jobs" class="text-gray-600 hover:text-primary transition-colors font-medium">Job Openings</a>
                        <a href="#about" class="text-gray-600 hover:text-primary transition-colors font-medium">About</a>
                        <a href="#contact" class="text-gray-600 hover:text-primary transition-colors font-medium">Contact</a>
                    </nav>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="bg-[#ef4444] text-white px-4 py-2 rounded-md font-medium hidden sm:block hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-[#ef4444] px-4 py-2 rounded-md font-medium hover:bg-[#fef2f2] transition-colors border border-[#ef4444]">
                            Sign Up
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="lg:hidden text-gray-600 hover:text-primary">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4 border-t border-gray-100">
                    <nav class="flex flex-col space-y-3">
                        <a href="#features" class="text-gray-600 hover:text-primary transition-colors font-medium">Features</a>
                        <a href="#jobs" class="text-gray-600 hover:text-primary transition-colors font-medium">Job Openings</a>
                        <a href="#about" class="text-gray-600 hover:text-primary transition-colors font-medium">About</a>
                        <a href="#contact" class="text-gray-600 hover:text-primary transition-colors font-medium">Contact</a>
                        <div class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                            <a href="{{ route('login') }}" class="block text-center bg-[#ef4444] text-white px-4 py-2 rounded-md font-medium hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="block text-center bg-white text-[#ef4444] px-4 py-2 rounded-md font-medium hover:bg-[#fef2f2] transition-colors border border-[#ef4444]">
                                Sign Up
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Modern Hero Section -->
        <section class="hero-gradient text-gray-900 py-20 lg:py-32 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-32 h-32 bg-white/5 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-40 h-40 bg-white/5 rounded-full filter blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <h1 class="text-4xl lg:text-5xl font-bold leading-tight">
                                <span class="text-white">National Olympic Committee</span><br>
                                <span class="text-nocis-gradient">Information System</span>
                            </h1>

                            <p class="text-xl text-white/90 leading-relaxed max-w-lg">
                                Transforming Olympic management with cutting-edge technology and seamless operations.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('login') }}" class="bg-[#ef4444] text-white px-6 py-3 rounded-lg font-medium inline-flex items-center justify-center shadow-lg hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                                <i class="fas fa-rocket mr-2"></i>
                                Get Started
                            </a>

                            <a href="#jobs" class="bg-white/20 backdrop-blur-sm border border-white/30 text-white px-8 py-3 rounded-lg hover:bg-white/30 transition-colors font-medium inline-flex items-center justify-center">
                                <i class="fas fa-briefcase mr-2"></i>
                                Browse Jobs
                            </a>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="flex items-center space-x-6 pt-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                <span class="text-sm">Trusted by 500+ organizations</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-2"></i>
                                <span class="text-sm">4.9/5 Customer Satisfaction</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="floating-animation">
                            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl shadow-2xl border border-white/20">
                                <img src="{{ asset('images/kongres.jpeg') }}" alt="Olympic Congress" class="rounded-xl w-full h-auto">
                                <div class="mt-4 text-center">
                                    <h3 class="text-white font-semibold">Olympic Excellence</h3>
                                    <p class="text-white/80 text-sm">Powering the future of sports management</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
                <div class="scroll-indicator">
                    <i class="fas fa-chevron-down text-white/60 text-2xl"></i>
                </div>
            </div>
        </section>

        <!-- Job Listings Section - Modern Design -->
        <section id="jobs" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-medium mb-4">
                        <i class="fas fa-briefcase mr-2"></i>
                        Career Opportunities
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Explore Exciting <span class="text-primary">Job Openings</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Join our team and be part of the Olympic movement. From event coordination to facility management, find your perfect role.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    <!-- Job Card 1 -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Event Coordinator</h3>
                                <span class="job-badge px-3 py-1 rounded-full text-xs font-medium mt-2 inline-block">
                                    Full-time Position
                                </span>
                            </div>
                            <button class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                        <p class="text-gray-600 mb-4 h-16">Coordinate and manage Olympic event operations, ensuring smooth execution of all activities with international standards.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">📍 Jakarta</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">🎯 Event Management</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">🏅 Olympic Games</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-500">Posted 2 days ago</span>
                            </div>
                            <a href="{{ route('jobs.index') }}" class="text-primary hover:text-primary-dark font-medium inline-flex items-center">
                                View Details <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Job Card 2 -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Volunteer Coordinator</h3>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium mt-2 inline-block">
                                    Part-time Position
                                </span>
                            </div>
                            <button class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                        <p class="text-gray-600 mb-4 h-16">Recruit, train, and manage volunteers for various Olympic events. Build community engagement and create memorable experiences.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">📍 Bandung</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">🤝 Volunteer Management</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">👥 Community Engagement</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-500">Posted 1 week ago</span>
                            </div>
                            <a href="{{ route('jobs.index') }}" class="text-primary hover:text-primary-dark font-medium inline-flex items-center">
                                View Details <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Job Card 3 -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Sports Facility Manager</h3>
                                <span class="job-badge px-3 py-1 rounded-full text-xs font-medium mt-2 inline-block">
                                    Full-time Position
                                </span>
                            </div>
                            <button class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                        <p class="text-gray-600 mb-4 h-16">Oversee management and maintenance of world-class sports facilities for Olympic training and international competitions.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">📍 Surabaya</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">🏟️ Facility Management</span>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">🎽 Sports Operations</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                <span class="text-sm text-gray-500">Posted 3 days ago</span>
                            </div>
                            <a href="{{ route('jobs.index') }}" class="text-primary hover:text-primary-dark font-medium inline-flex items-center">
                                View Details <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('jobs.index') }}" class="btn-primary text-white px-8 py-4 rounded-lg font-medium inline-flex items-center justify-center text-lg shadow-lg">
                        <i class="fas fa-search mr-3"></i>
                        Explore All Opportunities
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section - Modern Cards -->
        <section id="features" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-medium mb-4">
                        <i class="fas fa-star mr-2"></i>
                        Premium Features
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Powerful <span class="text-primary">Tools</span> for Olympic Management
                    </h2>
                    <p class="text-xl text-gray-600">Comprehensive solutions designed for excellence</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mb-6 mx-auto">
                            <i class="fas fa-calendar-alt text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Event Management</h3>
                        <p class="text-gray-600 mb-6">Comprehensive tools for planning, organizing, and managing Olympic events with real-time tracking and analytics.</p>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center justify-center">
                            Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mb-6 mx-auto">
                            <i class="fas fa-users-cog text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Worker Management</h3>
                        <p class="text-gray-600 mb-6">Efficient system for managing staff, volunteers, and worker assignments across multiple events and locations.</p>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center justify-center">
                            Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mb-6 mx-auto">
                            <i class="fas fa-sitemap text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Job Categories</h3>
                        <p class="text-gray-600 mb-6">Organized classification system for different roles and responsibilities with customizable workflows.</p>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center justify-center">
                            Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 card-hover text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mb-6 mx-auto">
                            <i class="fas fa-chart-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Analytics Dashboard</h3>
                        <p class="text-gray-600 mb-6">Real-time data visualization and reporting with AI-powered insights for informed decision making.</p>
                        <a href="#" class="text-primary hover:text-primary-dark font-medium inline-flex items-center justify-center">
                            Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section with Modern Design -->
        <section id="about" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="relative">
                        <div class="bg-primary/5 rounded-3xl p-8 relative overflow-hidden">
                            <img src="{{ asset('images/indonesia-olympic-logo.png') }}" alt="Indonesia Olympic Logo" class="w-full h-auto rounded-2xl">
                            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-primary/20 rounded-full"></div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-medium mb-4">
                                <i class="fas fa-info-circle mr-2"></i>
                                About NOCIS
                            </span>
                            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                                Revolutionizing <span class="text-primary">Olympic Management</span>
                            </h2>
                            <p class="text-lg text-gray-600 mb-6">
                                The National Olympic Committee Information System (NOCIS) is a comprehensive digital platform designed to streamline and enhance the management of Olympic committee operations.
                            </p>
                            <p class="text-gray-600 mb-8">
                                Our system integrates event management, worker coordination, job categorization, and advanced analytics to provide a unified solution for national Olympic committees.
                            </p>
                        </div>

                        <!-- Stats with Modern Design -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-primary/5 p-6 rounded-2xl text-center">
                                <div class="text-3xl font-bold text-primary mb-2">10+</div>
                                <div class="text-sm text-gray-600 font-medium">Managed Events</div>
                                <div class="text-xs text-gray-500 mt-1">International & National</div>
                            </div>
                            <div class="bg-primary/5 p-6 rounded-2xl text-center">
                                <div class="text-3xl font-bold text-primary mb-2">500+</div>
                                <div class="text-sm text-gray-600 font-medium">Registered Workers</div>
                                <div class="text-xs text-gray-500 mt-1">Active Professionals</div>
                            </div>
                            <div class="bg-primary/5 p-6 rounded-2xl text-center">
                                <div class="text-3xl font-bold text-primary mb-2">20+</div>
                                <div class="text-sm text-gray-600 font-medium">Job Categories</div>
                                <div class="text-xs text-gray-500 mt-1">Specialized Roles</div>
                            </div>
                            <div class="bg-primary/5 p-6 rounded-2xl text-center">
                                <div class="text-3xl font-bold text-primary mb-2">95%</div>
                                <div class="text-sm text-gray-600 font-medium">Satisfaction Rate</div>
                                <div class="text-xs text-gray-500 mt-1">Client Feedback</div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="pt-6">
                            <a href="{{ route('login') }}" class="bg-[#ef4444] w-full text-center text-white px-6 py-3 rounded-lg font-medium inline-flex items-center justify-center text-lg shadow-lg hover:bg-[#dc2626] transition-colors border border-[#ef4444]">
                                <i class="fas fa-play mr-3"></i>
                                Experience NOCIS Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section with Modern Form -->
        <section id="contact" class="py-20 bg-gradient-to-br from-primary/5 to-secondary/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="space-y-6">
                        <div>
                            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-medium mb-4">
                                <i class="fas fa-envelope mr-2"></i>
                                Get in Touch
                            </span>
                            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                                Connect With <span class="text-primary">Our Team</span>
                            </h2>
                            <p class="text-lg text-gray-600 mb-8">
                                Have questions or need support? Our dedicated team is ready to assist you with any inquiries about the NOCIS platform.
                            </p>
                        </div>

                        <!-- Contact Info with Icons -->
                        <div class="space-y-6">
                            <div class="flex items-start p-4 bg-white rounded-xl shadow-sm">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-primary text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Email Support</h3>
                                    <a href="mailto:contact@noc-indonesia.org" class="text-primary hover:text-primary-dark transition-colors">contact@noc-indonesia.org</a>
                                </div>
                            </div>

                            <div class="flex items-start p-4 bg-white rounded-xl shadow-sm">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-primary text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Phone Support</h3>
                                    <a href="tel:+62211234567" class="text-primary hover:text-primary-dark transition-colors">+62 21 123 4567</a>
                                </div>
                            </div>

                            <div class="flex items-start p-4 bg-white rounded-xl shadow-sm">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Headquarters</h3>
                                    <address class="not-italic text-gray-600">Jl. Olympic No. 123, Jakarta, Indonesia</address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modern Contact Form -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                            Send Us a Message
                        </h3>

                        <form class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" id="name" name="name" placeholder="Your full name"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="your@email.com"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" placeholder="Brief description"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                                <textarea id="message" name="message" rows="5" placeholder="How can we help you?"
