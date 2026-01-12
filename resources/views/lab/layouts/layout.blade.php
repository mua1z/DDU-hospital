<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DDU Clinics - Lab Technician')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-primary': '#7c3aed', /* Purple theme for lab */
                        'lab-secondary': '#8b5cf6',
                        'lab-accent': '#10b981',
                        'lab-light': '#f5f3ff',
                        'lab-dark': '#5b21b6',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .sidebar {
            transition: all 0.3s ease;
        }
        
        .dashboard-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #7c3aed;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #5b21b6;
        }
    </style>
    @yield('styles')
</head>
<body class="font-sans bg-gray-50">
    <!-- Mobile Menu Toggle Button -->
    <button id="menuToggle" class="lg:hidden fixed top-4 left-4 z-50 p-3 rounded-lg bg-lab-primary text-white shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('lab.partials.sidebar')
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            @include('lab.partials.topbar')
            
            <!-- Dashboard Content -->
            <div class="p-4 lg:p-6">
                @if(session('success') || session('status'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow relative rounded-md" role="alert">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-lg"><i class="fas fa-check-circle mr-2"></i>Success</p>
                            <p class="mt-1">{{ session('success') ?? session('status') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-700 hover:text-green-900"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow relative rounded-md" role="alert">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-lg"><i class="fas fa-exclamation-circle mr-2"></i>Error</p>
                            <p class="mt-1">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-red-700 hover:text-red-900"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                @endif
                
                @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow relative rounded-md" role="alert">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-lg"><i class="fas fa-exclamation-triangle mr-2"></i>Validation Error</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-700 hover:text-red-900"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
        
        // Set current date
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateElement = document.getElementById('currentDate');
        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('en-US', options);
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth < 1024 && 
                sidebar && 
                menuToggle && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
        
        // Add active class to current menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.nav-item');
            
            menuItems.forEach(item => {
                const link = item.querySelector('a');
                if (link) {
                    const href = link.getAttribute('href');
                    if (href) {
                        // Normalize paths for comparison
                        const linkPath = new URL(href, window.location.origin).pathname;
                        // Check if current path matches or starts with the link path
                        if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
                            link.classList.add('bg-purple-800', 'bg-opacity-50');
                        }
                    }
                }
            });
            
            // Update CSRF tokens in all forms
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                document.querySelectorAll('input[name="_token"]').forEach(input => {
                    input.value = csrfToken;
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>