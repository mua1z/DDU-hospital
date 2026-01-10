<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'DDU Clinic'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; 
            font-size: 15px; 
            line-height: 1.6;
        }
        .brand-text { color: #4c1d95; }
        .brand-bg { background-color: #4c1d95; }
        .brand-gradient { background: linear-gradient(135deg, #4c1d95 0%, #312e81 100%); }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="w-full bg-[#4c1d95] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white p-1 flex items-center justify-center">
                        <img class="h-full w-full object-contain" src="{{ asset('images/logo.png') }}" alt="DDU Logo">
                    </div>
                    <span class="font-bold text-xl tracking-tight text-white">DDU Clinic</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-white hover:text-purple-200 font-medium transition-colors">Home</a>
                    <a href="{{ url('/about') }}" class="text-white hover:text-purple-200 font-medium transition-colors">About</a>
                    <a href="{{ url('/services') }}" class="text-white hover:text-purple-200 font-medium transition-colors">Services</a>
                    <a href="{{ url('/contact') }}" class="text-white hover:text-purple-200 font-medium transition-colors">Contact</a>
                    
                    <div class="ml-4 flex items-center space-x-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-medium text-white hover:underline">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="font-medium text-white hover:underline">
                                    Login
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-white hover:text-purple-200 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#4c1d95] text-white py-6 border-t border-[#312e81] mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">
                &copy; {{ date('Y') }} Dire Dawa University Student Clinic | Support
            </p>
        </div>
    </footer>

</body>
</html>
