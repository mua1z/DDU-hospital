<aside class="sidebar w-64 bg-gradient-to-b from-purple-900 to-purple-800 text-white flex flex-col fixed lg:static h-full z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-prescription-bottle-alt text-purple-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">{{ __('DDU Clinics') }}</h1>
                <p class="text-purple-200 text-xs">{{ __('Pharmacy Portal') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Pharmacist Profile -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-purple-800 flex items-center justify-center">
                <i class="fas fa-user-md text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-purple-200 text-sm">{{ __('Pharmacy Department') }}</p>
                <p class="text-purple-300 text-xs">ID: {{ auth()->user()->dduc_id }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6">
        <ul class="space-y-2">
            <li class="nav-item">
                <a href="{{ route('pharmacy.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.view-prescriptions') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-prescription"></i>
                    <span>{{ __('View Prescriptions') }}</span>
                    @php $pendingPrescriptions = \App\Models\Prescription::where('status', 'pending')->count(); @endphp
                    @if($pendingPrescriptions > 0)
                    <span class="ml-auto bg-purple-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">{{ $pendingPrescriptions }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.dispense-medications') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-pills"></i>
                    <span>{{ __('Dispense Medications') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.inventory-management') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-boxes"></i>
                    <span>{{ __('Inventory Management') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.check-expiry') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-calendar-times"></i>
                    <span>{{ __('Check Expiry') }}</span>
                    @php $expiringSoon = \App\Models\Inventory::where('location', 'pharmacy')->whereBetween('expiry_date', [now(), now()->addDays(30)])->count(); @endphp
                    @if($expiringSoon > 0)
                    <span class="ml-auto bg-yellow-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center blink-warning">{{ $expiringSoon }}</span>
                    @endif
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
                <ul x-show="open" x-collapse class="ml-6 mt-2 space-y-1 bg-green-700 rounded-lg p-2">
                    <li>
                        <a href="{{ route('pharmacy.inventory.export.pdf') }}" class="flex items-center space-x-2 p-2 text-sm rounded-lg bg-green-600 transition">
                            <i class="fas fa-file-pdf text-red-400"></i>
                            <span>{{ __('Inventory (PDF)') }}</span>
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