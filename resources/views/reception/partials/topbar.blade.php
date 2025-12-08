<header class="bg-white shadow-sm p-4 lg:p-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 animate-fade-in">@yield('page-title', 'Welcome, Receptionist')</h1>
            <p class="text-gray-600 mt-1">DDU Clinic Management System - @yield('page-subtitle', 'Reception Dashboard')</p>
        </div>
        
        <div class="flex items-center space-x-4 mt-4 lg:mt-0">
            <!-- Notifications -->
            <div class="relative">
                <button class="p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-bell text-gray-700 text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse">3</span>
                </button>
            </div>
            
            <!-- Date Display -->
            <div class="hidden lg:block px-4 py-2 bg-ddu-light rounded-lg">
                <span class="text-gray-700 font-medium" id="currentDate"></span>
            </div>
        </div>
    </div>
</header>