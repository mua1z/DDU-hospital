<aside class="sidebar w-64 bg-gradient-to-b from-purple-900 to-purple-800 text-white flex flex-col fixed lg:static h-full z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">{{ __('DDU Clinics') }}</h1>
                <p class="text-purple-200 text-xs">{{ __('Admin Portal') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Admin Profile -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-purple-800 flex items-center justify-center">
                <i class="fas fa-user-shield text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-purple-200 text-sm">{{ __('System Administrator') }}</p>
                <p class="text-purple-300 text-xs">ID: {{ auth()->user()->dduc_id }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6">
        <ul class="space-y-2">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-users"></i>
                    <span>{{ __('Manage Users') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-cogs"></i>
                    <span>{{ __('System Settings') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.logs.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ __('System Logs') }}</span>
                </a>
            </li>
            
            <!-- Reports Section -->
            <li class="pt-4">
                <p class="text-purple-300 text-xs uppercase tracking-wider px-3 mb-2">{{ __('Reports') }}</p>
            </li>
            <li class="nav-item" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between space-x-3 p-3 rounded-lg bg-green-600 hover:bg-green-700 transition shadow-md">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-file-download"></i>
                        <span>{{ __('Export Reports') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>
                <ul x-show="open" x-collapse class="ml-6 mt-2 space-y-1">
                    <li>
                        <a href="{{ route('admin.users.export.pdf') }}" class="flex items-center space-x-2 p-2 text-sm rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-file-pdf text-red-400"></i>
                            <span>{{ __('Users (PDF)') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.export.excel') }}" class="flex items-center space-x-2 p-2 text-sm rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-file-excel text-green-400"></i>
                            <span>{{ __('Users (Excel)') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    
    <!-- Logout -->
    <div class="p-6 border-t border-purple-700">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg bg-green-600 hover:bg-green-700 transition text-left text-white shadow-md">
                <i class="fas fa-sign-out-alt"></i>
                <span>{{ __('Logout') }}</span>
            </button>
        </form>
    </div>
    
    <script>
        document.getElementById('logout-form')?.addEventListener('submit', function(e) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token) {
                const formToken = this.querySelector('input[name="_token"]');
                if (formToken) {
                    formToken.value = token;
                }
            }
        });
    </script>
</aside>
