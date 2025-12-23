<aside class="sidebar w-64 bg-gradient-to-b from-purple-900 to-purple-800 text-white flex flex-col fixed lg:static h-full z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-stethoscope text-purple-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">{{ __('DDU Clinics') }}</h1>
                <p class="text-purple-200 text-xs">{{ __('Doctor Portal') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Doctor Profile -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-purple-800 flex items-center justify-center">
                <i class="fas fa-user-md text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-purple-200 text-sm">{{ __('General Physician') }}</p>
                <p class="text-purple-300 text-xs">ID: {{ auth()->user()->dduc_id }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6">
        <ul class="space-y-2">
            <li class="nav-item">
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.view-appointments') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-calendar-check"></i>
                    <span>{{ __('View Appointments') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.request-lab-test') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-flask"></i>
                    <span>{{ __('Request Lab Test') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.view-lab-results') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-file-medical-alt"></i>
                    <span>{{ __('View Lab Results') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.write-prescription') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <span>{{ __('Write Prescription') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.document-history') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-history"></i>
                    <span>{{ __('Document Patient History') }}</span>
                </a>
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