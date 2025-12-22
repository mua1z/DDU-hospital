<div class="bg-white shadow-sm rounded-xl p-4 mb-6 flex justify-between items-center animate-fade-in">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Admin Dashboard</h2>
        <p class="text-gray-500 text-sm">DDU Clinic Management System - Admin Module</p>
    </div>
    
    <div class="flex items-center space-x-4">
        <div class="hidden md:block text-right mr-4">
            <p class="text-sm font-semibold text-gray-800" id="currentDate"></p>
        </div>
        
        <!-- Notifications -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="text-gray-500 hover:text-purple-600 transition relative">
                <i class="fas fa-bell text-xl"></i>
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>
            
            <!-- Dropdown -->
            <div x-show="open" 
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 hidden"
                 :class="{ 'block': open, 'hidden': !open }">
                <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                    <span class="font-semibold text-gray-800">Notifications</span>
                    <a href="#" class="text-xs text-purple-600 hover:underline">Mark all read</a>
                </div>
                
                <div class="max-h-64 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 transition">
                            <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'New Notification' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            No new notifications
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="h-8 w-px bg-gray-200 mx-2"></div>
        
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold border border-purple-200">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <span class="font-medium text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>

<!-- Alpine.js for dropdown -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
