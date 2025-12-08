<aside class="sidebar w-64 bg-gradient-to-b from-ddu-primary to-ddu-secondary text-white flex flex-col fixed lg:static h-full z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-blue-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-clinic-medical text-ddu-primary text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">DDU Clinics</h1>
                <p class="text-blue-200 text-xs">Clinic Management System</p>
            </div>
        </div>
    </div>
    
    <!-- User Profile -->
    <div class="p-6 border-b border-blue-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-blue-800 flex items-center justify-center">
                <i class="fas fa-user-md text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-semibold">Receptionist / Clerk</h2>
                <p class="text-blue-200 text-sm">DDU Main Campus</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6">
        <ul class="space-y-2">
            <li class="nav-item">
                <a href="{{ route('reception.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reception.register-patient') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-user-plus"></i>
                    <span>Register Patient</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reception.search-patients') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-search"></i>
                    <span>Search Patients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reception.search-patients') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-user-circle"></i>
                    <span>View Patient Info</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reception.schedule-appointments') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Schedule Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reception.manage-walkin') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-walking"></i>
                    <span>Manage Walk-In</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Logout -->
    <div class="p-6 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-800 hover:bg-opacity-50 transition text-left text-white">
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