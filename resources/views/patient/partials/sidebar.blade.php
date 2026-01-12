<aside class="sidebar fixed lg:static inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl h-screen flex flex-col justify-between">
    <div>
        <!-- Logo Area -->
        <div class="p-6 border-b border-blue-700/50 flex items-center justify-center">
            <div class="flex flex-col items-center">
                <div class="bg-white p-2 rounded-full shadow-lg mb-2">
                    <i class="fas fa-heartbeat text-3xl text-blue-600"></i>
                </div>
                <h1 class="text-xl font-bold tracking-wider">DDU Clinic</h1>
                <span class="text-xs text-blue-200 uppercase tracking-widest mt-1">Patient Portal</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-8 px-4 space-y-2">
            <!-- Dashboard -->
            <div class="nav-item group">
                <a href="{{ route('patient.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.dashboard') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-home w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Medical History -->
            <div class="nav-item group">
                <a href="{{ route('patient.medical-records') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.medical-records') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-file-medical w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">Medical History</span>
                </a>
            </div>

            <!-- My Appointments -->
            <div class="nav-item group">
                <a href="{{ route('patient.my-appointments') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.my-appointments') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-calendar-check w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">My Appointments</span>
                </a>
            </div>

             <!-- Book Appointment -->
             <div class="nav-item group">
                <a href="{{ route('patient.book-appointment') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.book-appointment') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-plus-circle w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">Book Appointment</span>
                </a>
            </div>

            <!-- Prescriptions -->
            <div class="nav-item group">
                <a href="{{ route('patient.prescriptions') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.prescriptions*') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-prescription w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">My Prescriptions</span>
                </a>
            </div>

            <!-- Lab Results -->
            <div class="nav-item group">
                <a href="{{ route('patient.lab-results') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.lab-results*') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-flask w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">Lab Results</span>
                </a>
            </div>

            <!-- Edit Profile -->
            <div class="nav-item group">
                <a href="{{ route('patient.edit-profile') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('patient.edit-profile') ? 'bg-white/20 shadow-inner' : '' }}">
                    <i class="fas fa-user-edit w-6 text-center text-blue-300 group-hover:text-blue-100 transition-colors"></i>
                    <span class="font-medium">Edit Profile</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- User Profile / Logout -->
    <div class="p-4 border-t border-blue-700/50 bg-blue-900/50">
        <div class="flex items-center space-x-3 mb-4 px-2">
            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold shadow-md">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="font-medium text-sm truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-blue-300 truncate">Patient</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center space-x-2 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
