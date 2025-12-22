<header class="bg-white shadow-sm p-4 lg:p-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 animate-fade-in">@yield('page-title', 'Welcome, Lab Technician')</h1>
            <p class="text-gray-600 mt-1">DDU Clinic Management System - @yield('page-subtitle', 'Laboratory Dashboard')</p>
        </div>
        
        <div class="flex items-center space-x-4 mt-4 lg:mt-0">
            <!-- Lab Status -->
            <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-purple-50 rounded-lg">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-gray-700 font-medium">
                    Lab: <span class="text-purple-600 font-bold">Operational</span>
                </span>
            </div>
            
            <!-- Notifications -->
            <div class="relative" id="notificationDropdownContainer">
                <button class="p-2 rounded-full hover:bg-gray-100" onclick="document.getElementById('notificationList').classList.toggle('hidden')">
                    <i class="fas fa-bell text-gray-700 text-xl"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>
                
                <!-- Dropdown -->
                <div id="notificationList" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50 border border-gray-200">
                    <div class="p-3 border-b text-sm font-semibold text-gray-700 flex justify-between">
                        <span>Notifications</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="text-xs text-blue-600 cursor-pointer">Mark all read</span>
                        @endif
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ $notification->data['link'] ?? '#' }}" class="block p-3 hover:bg-gray-50 border-b last:border-0 transition">
                            <p class="text-sm text-gray-800">{{ $notification->data['message'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                        @empty
                        <div class="p-4 text-center text-sm text-gray-500">No new notifications</div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Date Display -->
            <div class="hidden lg:block px-4 py-2 bg-purple-50 rounded-lg">
                <span class="text-gray-700 font-medium" id="currentDate"></span>
            </div>
        </div>
    </div>
</header>