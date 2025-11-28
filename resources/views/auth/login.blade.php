<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NOCIS</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .congress-image {
            background: linear-gradient(135deg, rgba(196, 64, 0, 0.7) 0%, rgba(163, 0, 0, 0.8) 100%),
                        url('{{ asset('images/kongres.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .form-input {
            transition: all 0.3s ease;
            background: transparent;
        }
        
        .form-input:focus {
            transform: translateY(-2px);
        }
        
        .welcome-text {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        @media (max-width: 1024px) {
            .login-container {
                padding: 2rem 1rem;
            }
            
            .congress-image {
                display: none;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    
    <div class="min-h-screen flex">
        {{-- Left Side - Congress Image --}}
        <div class="hidden lg:flex lg:w-1/2 congress-image relative">
            <div class="absolute inset-0 bg-gradient-to-br from-red-600/80 to-red-800/90"></div>
            <div class="relative z-10 flex flex-col justify-center items-start text-white p-12 w-full">
                <div class="text-left">
                    <h1 class="text-4xl font-bold mb-4 welcome-text">Selamat Datang di</h1>
                    <div class="mb-8">
                        <img src="{{ asset('images/indonesia-olympic-logo.png') }}?v={{ time() }}" 
                             alt="Indonesia Olympic Committee" 
                             class="h-16 w-auto mb-4 filter brightness-0 invert">
                        <div class="text-white">
                            <h2 class="text-2xl font-bold mb-1">NOCIS</h2>
                            <p class="text-lg opacity-90">By Group 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center login-container p-8 bg-white">
        <div class="w-full login-form">
            
            {{-- Logo --}}
            <div class="text-center mb-8">
                <img src="{{ asset('images/indonesia-olympic-logo.png') }}?v={{ time() }}" 
                     alt="Indonesia Olympic Committee" 
                     class="h-16 w-auto mx-auto mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Login</h2>
            </div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
            {{-- Username Field --}}
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-600 mb-2">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="{{ old('username', 'admin') }}" 
                       placeholder="admin"
                       class="form-input w-full px-4 py-4 border-0 border-b-2 border-gray-200 bg-transparent focus:outline-none focus:border-blue-500 transition-colors text-lg"
                       required>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Field --}}
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                <div class="relative">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="••••••••••••"
                           class="form-input w-full px-4 py-4 border-0 border-b-2 border-gray-200 bg-transparent focus:outline-none focus:border-blue-500 transition-colors text-lg pr-12"
                           required>
                    <button type="button" 
                            id="toggle-password"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me & Terms --}}
            <div class="flex items-center mb-8">
                <input type="checkbox" 
                       id="remember" 
                       name="remember" 
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-600">
                    I accept the Terms & Conditions
                </label>
            </div>

            {{-- Login Button --}}
            <button type="submit" 
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-lg">
                Login
            </button>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-400 mr-2 mt-0.5"></i>
                            <div>
                                <h3 class="text-sm font-medium text-red-800">Login Failed</h3>
                                <div class="mt-1 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Divider --}}
                <div class="text-center my-6">
                    <span class="text-gray-400 text-sm">ATAU</span>
                </div>

                {{-- Footer Links --}}
                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-600">
                        Lupa password? 
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-700 font-medium">Reset Password</a>
                    </p>
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Register Akun</a>
                    </p>
                </div>
            </form>

            {{-- Mobile Header for small screens --}}
            <div class="lg:hidden text-center mt-8 pt-8">
                <div class="text-xs text-gray-500">
                    <p>KONGRES LUAR BIASA 2024</p>
                    <p>KOMITE OLIMPIADE INDONESIA</p>
                    <p>8 Maret 2024 | Hotel Fairmont Jakarta</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Auto-focus on first empty field
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            
            if (!usernameInput.value) {
                usernameInput.focus();
            } else {
                passwordInput.focus();
            }
        });
    </script>
</body>
</html>
