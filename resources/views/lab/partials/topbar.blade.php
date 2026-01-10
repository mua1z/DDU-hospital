<header class="bg-white shadow-sm p-4 lg:p-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 animate-fade-in">@yield('page-title', 'Welcome, Lab Technician')</h1>
            <p class="text-gray-600 mt-1">DDU Clinic Management System - @yield('page-subtitle', 'Laboratory Dashboard')</p>
        </div>
        
        <!-- Search Bar -->
        <div class="flex-1 mx-4 lg:mx-8 hidden lg:block mt-4 lg:mt-0">
            <form action="{{ route('global.search') }}" method="GET" class="relative">
                <input type="text" name="query" placeholder="Search requests..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </form>
        </div>

        <div class="flex items-center space-x-4 mt-4 lg:mt-0">
            <!-- Lab Status -->
            <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-purple-50 rounded-lg">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-gray-700 font-medium">
                    Lab: <span class="text-purple-600 font-bold">Operational</span>
                </span>
            </div>
            
            <!-- Language Switcher -->
            <div x-data="{ open: false }" class="relative z-50 mr-4">
                <button @click="open = !open" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition ease-in-out duration-150 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9m0 18c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9m0 18c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9m0 18c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9m0 18c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9" />
                    </svg>
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" 
                     @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl py-2 border border-gray-100 z-50">
                     
                    <div class="px-4 py-2 border-b border-gray-100 mb-1">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Select Language</p>
                    </div>

                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                        <div class="flex items-center">
                            <span class="w-6 text-center text-lg mr-2">🇺🇸</span>
                            <span class="font-medium">English</span>
                        </div>
                        @if(app()->getLocale() == 'en')
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </a>
                    
                    <a href="{{ route('lang.switch', 'am') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                        <div class="flex items-center">
                            <span class="w-6 text-center text-lg mr-2">🇪🇹</span>
                            <span class="font-medium">Amharic</span>
                        </div>
                        @if(app()->getLocale() == 'am')
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </a>
                    
                    <a href="{{ route('lang.switch', 'om') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                        <div class="flex items-center">
                            <span class="w-6 text-center text-lg mr-2">🇪🇹</span>
                            <span class="font-medium">Afaan Oromo</span>
                        </div>
                        @if(app()->getLocale() == 'om')
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Notifications -->
            <div class="relative" x-data="{ 
                open: false,
                unreadCount: {{ auth()->user()->unreadNotifications->count() }},
                markRead() {
                    if (this.unreadCount > 0) {
                        fetch('{{ route('notifications.mark-read') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        });
                        this.unreadCount = 0;
                    }
                }
            }">
                <button @click="markRead(); open = !open" class="p-2 rounded-full hover:bg-gray-100 relative transition">
                    <i class="fas fa-bell text-gray-700 text-xl"></i>
                    <template x-if="unreadCount > 0">
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse" x-text="unreadCount"></span>
                    </template>
                </button>
                
                <!-- Dropdown -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50 border border-gray-200"
                     style="display: none;">
                    <div class="p-3 border-b text-sm font-semibold text-gray-700 flex justify-between">
                        <span>Notifications</span>
                        <template x-if="unreadCount > 0">
                            <span class="text-xs text-blue-600">Marking read...</span>
                        </template>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ $notification->data['link'] ?? '#' }}" class="block p-3 hover:bg-gray-50 border-b last:border-0 transition">
                            <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'New Notification' }}</p>
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
<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>