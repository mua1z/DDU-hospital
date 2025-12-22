<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DDU Clinic') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .brand-text { color: #004e66; }
        .brand-bg { background-color: #004e66; }
        .brand-gradient { background: linear-gradient(135deg, #004e66 0%, #002a36 100%); }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img class="h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="DDU Logo">
                    <span class="font-bold text-xl tracking-tight brand-text">DDU Clinic</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-600 hover:text-[#004e66] font-medium transition-colors">Home</a>
                    <a href="#about" class="text-gray-600 hover:text-[#004e66] font-medium transition-colors">About</a>
                    <a href="#services" class="text-gray-600 hover:text-[#004e66] font-medium transition-colors">Services</a>
                    <a href="#contact" class="text-gray-600 hover:text-[#004e66] font-medium transition-colors">Contact</a>
                    
                    <div class="ml-4 flex items-center space-x-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full brand-bg text-white font-medium hover:bg-[#003d50] transition-transform transform hover:-translate-y-0.5 shadow-lg shadow-blue-900/20">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full brand-bg text-white font-medium hover:bg-[#003d50] transition-transform transform hover:-translate-y-0.5 shadow-lg shadow-blue-900/20">
                                    Login Portal
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 hover:text-gray-900 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://img.freepik.com/free-photo/blur-hospital-clinic-interior_74190-5203.jpg')] bg-cover bg-center"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-r from-blue-50/90 to-white/60"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-[#004e66] text-xs font-bold tracking-wider mb-6">
                    UNIVERSITY HEALTH SERVICES
                </span>
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6 leading-tight">
                    Compassionate Care <br/>
                    <span class="brand-text">Within Your Reach</span>
                </h1>
                <p class="mt-4 text-xl text-gray-600 mb-10 leading-relaxed">
                    Providing high-quality medical services to the Dire Dawa University community. 
                    Students, staff, and faculty—your health is our priority.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 rounded-full brand-bg text-white font-bold text-lg hover:bg-[#003d50] transition-all shadow-xl hover:shadow-2xl">
                        Book Appointment
                    </a>
                    <a href="#services" class="px-8 py-4 rounded-full bg-white text-[#004e66] border border-gray-200 font-bold text-lg hover:bg-gray-50 transition-all shadow-md">
                        Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="absolute -top-4 -left-4 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-4 -right-4 w-72 h-72 bg-purple-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                        <!-- Placeholder for a clinic image, using hero pattern or logo for now -->
                        <div class="bg-gray-100 h-96 flex items-center justify-center brand-bg">
                             <img src="{{ asset('images/logo.png') }}" class="h-32 opacity-20" alt="About Image">
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">About DDU Clinic</h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Established to serve the vibrant academic community of Dire Dawa University, our clinic offers comprehensive primary healthcare services. We are dedicated to promoting wellness and treating illness with expertise and empathy.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-lg brand-bg text-white">
                                    <i class="fas fa-user-md text-xl"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Expert Doctors</h3>
                                <p class="mt-2 text-sm text-gray-500">Qualified physicians available for consultation.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="flex items-center justify-center h-12 w-12 rounded-lg brand-bg text-white">
                                    <i class="fas fa-heartbeat text-xl"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Emergency Care</h3>
                                <p class="mt-2 text-sm text-gray-500">24/7 readiness for medical emergencies.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-gray-600 text-lg">Comprehensive healthcare solutions tailored for our university community.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-gray-100 group">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-[#004e66] transition-colors">
                        <i class="fas fa-stethoscope text-2xl text-[#004e66] group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">General Consultation</h3>
                    <p class="text-gray-600">Routine check-ups, diagnosis, and treatment plans from our general practitioners.</p>
                </div>

                <!-- Service 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-gray-100 group">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-[#004e66] transition-colors">
                        <i class="fas fa-flask text-2xl text-[#004e66] group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laboratory</h3>
                    <p class="text-gray-600">Advanced diagnostic lab services for accurate and timely test results.</p>
                </div>

                <!-- Service 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-gray-100 group">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-[#004e66] transition-colors">
                        <i class="fas fa-pills text-2xl text-[#004e66] group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pharmacy</h3>
                    <p class="text-gray-600">Fully stocked in-house pharmacy providing essential medications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#004e66] rounded-3xl overflow-hidden shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-12 text-white">
                        <h2 class="text-3xl font-bold mb-6">Get in Touch</h2>
                        <p class="text-blue-100 mb-10 text-lg">Have questions or need assistance? Reach out to our reception desk or visit us on campus.</p>
                        
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-lg">Location</h4>
                                    <p class="text-blue-100">Dire Dawa University Main Campus</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-lg">Phone</h4>
                                    <p class="text-blue-100">+251 251 11 11 11</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center text-white">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-lg">Email</h4>
                                    <p class="text-blue-100">clinic@ddu.edu.et</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative bg-gray-900 p-12 lg:p-0">
                        <!-- Simulated Map or Image -->
                        <div class="h-full w-full bg-gray-800 opacity-50 flex items-center justify-center">
                            <span class="text-white"><i class="fas fa-map text-6xl"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-3 mb-6 md:mb-0">
                    <img class="h-10 w-auto bg-white rounded-full p-1" src="{{ asset('images/logo.png') }}" alt="DDU Logo">
                    <span class="font-bold text-xl tracking-tight">DDU Clinic</span>
                </div>
                <div class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Dire Dawa University Clinic. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
