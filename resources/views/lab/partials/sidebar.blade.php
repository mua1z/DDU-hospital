<aside class="sidebar w-64 bg-gradient-to-b from-lab-primary to-lab-dark text-white flex flex-col fixed lg:static h-full z-40">
    <!-- Logo -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-flask text-lab-primary text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">DDU Clinics</h1>
                <p class="text-purple-200 text-xs">Laboratory Portal</p>
            </div>
        </div>
    </div>
    
    <!-- Lab Technician Profile -->
    <div class="p-6 border-b border-purple-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-purple-800 flex items-center justify-center">
                <i class="fas fa-user-md text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-semibold">Lab Technician</h2>
                <p class="text-purple-200 text-sm">Clinical Laboratory</p>
                <p class="text-purple-300 text-xs">Lab ID: LT-101</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6">
        <ul class="space-y-2">
            <li class="nav-item">
                <a href="{{ route('lab.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lab.pending-requests') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-clock"></i>
                    <span>Pending Requests</span>
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center animate-pulse">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lab.pending-requests') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-vial"></i>
                    <span>Process Test</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lab.upload-results') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-upload"></i>
                    <span>Upload Results</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lab.test-results') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-file-medical-alt"></i>
                    <span>Test Results</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lab.inventory') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('lab.quality-control') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Quality Control</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Logout -->
    <div class="p-6 border-t border-purple-700">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-purple-800 hover:bg-opacity-50 transition text-left text-white">
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