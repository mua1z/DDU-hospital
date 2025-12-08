<aside class="sidebar w-64 bg-gradient-to-b from-pharma-primary to-pharma-dark text-white flex flex-col fixed lg:static h-full z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-red-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-prescription-bottle-alt text-pharma-primary text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">DDU Clinics</h1>
                <p class="text-red-200 text-xs">Pharmacy Portal</p>
            </div>
        </div>
    </div>
    
    <!-- Pharmacist Profile -->
    <div class="p-6 border-b border-red-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-red-800 flex items-center justify-center">
                <i class="fas fa-user-md text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-semibold">Pharmacist</h2>
                <p class="text-red-200 text-sm">Pharmacy Department</p>
                <p class="text-red-300 text-xs">License: PH-2024-001</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6">
        <ul class="space-y-2">
            <li class="nav-item">
                <a href="{{ route('pharmacy.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.view-prescriptions') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-prescription"></i>
                    <span>View Prescriptions</span>
                    <span class="ml-auto bg-blue-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">8</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.dispense-medications') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-pills"></i>
                    <span>Dispense Medications</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.inventory-management') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.check-expiry') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-calendar-times"></i>
                    <span>Check Expiry</span>
                    <span class="ml-auto bg-yellow-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center blink-warning">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacy.generate-reports') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-chart-bar"></i>
                    <span>Generate Reports</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Logout -->
    <div class="p-6 border-t border-red-700">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-red-800 hover:bg-opacity-50 transition text-left text-white">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
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