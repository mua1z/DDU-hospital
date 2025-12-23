<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DDU Student Clinic</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css','resources/js/app.js'])
    @else
        <link rel="stylesheet" href="/build/assets/app.css">
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-slate-50 text-slate-800">
    <header class="bg-teal-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white p-1 flex items-center justify-center">
                    <img src="/images/logo.png" alt="DDU" class="w-full h-full object-contain" onerror="this.style.display='none'">
                </div>
                <span class="font-semibold text-lg">DDU Clinic</span>
            </a>
            <nav class="hidden md:flex gap-6 items-center">
                <a href="#home" class="hover:underline hover:text-sky-200 transition">{{ __('Home') }}</a>
                <a href="#about" class="hover:underline hover:text-sky-200 transition">{{ __('About') }}</a>
                <a href="#services" class="hover:underline hover:text-sky-200 transition">{{ __('Services') }}</a>
                <a href="#contact" class="hover:underline hover:text-sky-200 transition">{{ __('Contact') }}</a>
                
                <!-- Language Switcher -->
                <!-- Language Switcher -->
                <div x-data="{ open: false }" class="relative z-50">
                    <button @click="open = !open" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition ease-in-out duration-150 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9m0 18c1.657 0 3-9 3-9m-3 9c-1.657 0-3-9-3-9" />
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

                <a href="{{ route('login') }}" class="px-4 py-2 bg-sky-600 rounded hover:bg-sky-500 transition">{{ __('Login') }}</a>
            </nav>
            <div class="md:hidden">
                <!-- mobile menu placeholder -->
                <button class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="bg-gradient-to-r from-sky-100 to-emerald-100">
            <div class="max-w-6xl mx-auto px-6 py-24 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">{{ __('Welcome to DDU Student Clinic') }}</h1>
                <p class="text-slate-700 mb-8 text-lg">{{ __('Accessible, Student-Centered Healthcare for Every Need') }}</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('reception.schedule-appointments') }}" class="px-8 py-3 bg-sky-800 text-white rounded-lg shadow-lg hover:bg-sky-700 transition transform hover:-translate-y-1">{{ __('Book Appointment') }}</a>
                    <a href="#services" class="px-8 py-3 bg-sky-700 text-white rounded-lg shadow-lg hover:bg-sky-600 transition transform hover:-translate-y-1">{{ __('View Services') }}</a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="bg-white py-12">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-teal-700">5000+</div>
                        <div class="text-slate-600">{{ __('Students Served') }}</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-teal-700">24/7</div>
                        <div class="text-slate-600">{{ __('Emergency Support') }}</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-teal-700">15+</div>
                        <div class="text-slate-600">{{ __('Medical Services') }}</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-teal-700">98%</div>
                        <div class="text-slate-600">{{ __('Satisfaction Rate') }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 bg-slate-50">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">{{ __('About DDU Student Clinic') }}</h2>
                    <p class="text-slate-600 max-w-3xl mx-auto">{{ __('Committed to providing comprehensive healthcare services to Dire Dawa University students') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <img src="https://images.unsplash.com/photo-1586773860418-dc22f8b874bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Medical Team" class="rounded-lg shadow-lg">
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-slate-800 mb-4">{{ __('Our Mission & Vision') }}</h3>
                        <p class="text-slate-600 mb-4">{{ __('The DDU Student Clinic is dedicated to promoting the health and well-being of all university students through accessible, high-quality medical care and health education.') }}</p>
                        <p class="text-slate-600 mb-6">{{ __('We aim to create a healthy campus environment where students can thrive academically and personally.') }}</p>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Qualified medical professionals') }}</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Confidential and respectful care') }}</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('Modern medical facilities') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">{{ __('Our Services') }}</h2>
                    <p class="text-slate-600 max-w-3xl mx-auto">{{ __('Comprehensive healthcare services tailored for student needs') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Service 1 -->
                    <div class="bg-slate-50 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 mb-3">{{ __('Primary Care') }}</h3>
                        <p class="text-slate-600">{{ __('General check-ups, consultations, and treatment for common illnesses and injuries.') }}</p>
                    </div>
                    
                    <!-- Service 2 -->
                    <div class="bg-slate-50 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 mb-3">{{ __('Laboratory Services') }}</h3>
                        <p class="text-slate-600">{{ __('Blood tests, urine analysis, and other diagnostic laboratory services.') }}</p>
                    </div>
                    
                    <!-- Service 3 -->
                    <div class="bg-slate-50 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 mb-3">{{ __('Emergency Care') }}</h3>
                        <p class="text-slate-600">{{ __('24/7 emergency medical services for urgent health concerns.') }}</p>
                    </div>
                    
                    <!-- Service 4 -->
                    <div class="bg-slate-50 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 mb-3">{{ __('Health Education') }}</h3>
                        <p class="text-slate-600">{{ __('Workshops, counseling, and resources for maintaining optimal health.') }}</p>
                    </div>
                    
                    <!-- Service 5 -->
                    <div class="bg-slate-50 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 mb-3">{{ __('Vaccinations') }}</h3>
                        <p class="text-slate-600">{{ __('Immunization services and travel vaccinations as needed.') }}</p>
                    </div>
                    
                    <!-- Service 6 -->
                    <div class="bg-slate-50 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-rose-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 mb-3">{{ __('Mental Health Support') }}</h3>
                        <p class="text-slate-600">{{ __('Counseling and psychological support services for students.') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 bg-gradient-to-r from-sky-50 to-teal-50">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">{{ __('Contact Us') }}</h2>
                    <p class="text-slate-600 max-w-3xl mx-auto">{{ __('Get in touch with our clinic team for appointments or inquiries') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-2xl font-semibold text-slate-800 mb-6">{{ __('Get in Touch') }}</h3>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700">{{ __('Location') }}</h4>
                                    <p class="text-slate-600">{{ __('Dire Dawa University Main Campus') }}<br>{{ __('Student Services Building, Ground Floor') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700">{{ __('Phone') }}</h4>
                                    <p class="text-slate-600">{{ __('Emergency') }}: +251-XXX-XXX-XXX<br>{{ __('Appointments') }}: +251-XXX-XXX-XXX</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700">{{ __('Email') }}</h4>
                                    <p class="text-slate-600">clinic@ddu.edu.et<br>emergency@ddu.edu.et</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h4 class="font-semibold text-slate-700 mb-3">{{ __('Operating Hours') }}</h4>
                            <ul class="space-y-2 text-slate-600">
                                <li class="flex justify-between">
                                    <span>{{ __('Monday - Friday') }}</span>
                                    <span>8:00 AM - 6:00 PM</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>{{ __('Saturday') }}</span>
                                    <span>9:00 AM - 1:00 PM</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>{{ __('Emergency Services') }}</span>
                                    <span class="text-emerald-600 font-medium">{{ __('24/7 Available') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-8 shadow-sm">
                        <h3 class="text-2xl font-semibold text-slate-800 mb-6">{{ __('Send us a Message') }}</h3>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-slate-700 mb-2">{{ __('Full Name') }}</label>
                                <input type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-slate-700 mb-2">{{ __('Student ID') }}</label>
                                <input type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-slate-700 mb-2">{{ __('Email Address') }}</label>
                                <input type="email" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-slate-700 mb-2">{{ __('Message') }}</label>
                                <textarea rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
                            </div>
                            <button type="submit" class="w-full py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition">{{ __('Send Message') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-teal-800 to-sky-800 text-white py-12">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-4">{{ __('Ready to Schedule Your Visit?') }}</h2>
                <p class="mb-8 max-w-2xl mx-auto">{{ __('Book an appointment online or visit our clinic during operating hours. Emergency services available 24/7.') }}</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('reception.schedule-appointments') }}" class="px-8 py-3 bg-white text-teal-800 font-semibold rounded-lg shadow-lg hover:bg-slate-100 transition">{{ __('Book Online Now') }}</a>
                    <a href="#contact" class="px-8 py-3 bg-transparent border-2 border-white rounded-lg hover:bg-white/10 transition">{{ __('Contact Us') }}</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-teal-900 text-white">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-white p-1 flex items-center justify-center">
                            <img src="/images/logo.png" alt="DDU" class="w-full h-full object-contain" onerror="this.style.display='none'">
                        </div>
                        <span class="font-semibold text-lg">DDU Clinic</span>
                    </div>
                    <p class="text-slate-300">{{ __('Providing quality healthcare to Dire Dawa University students since 2005.') }}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">{{ __('Quick Links') }}</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-slate-300 hover:text-white transition">{{ __('Home') }}</a></li>
                        <li><a href="#about" class="text-slate-300 hover:text-white transition">{{ __('About Us') }}</a></li>
                        <li><a href="#services" class="text-slate-300 hover:text-white transition">{{ __('Services') }}</a></li>
                        <li><a href="#contact" class="text-slate-300 hover:text-white transition">{{ __('Contact') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">{{ __('Services') }}</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-slate-300 hover:text-white transition">{{ __('Primary Care') }}</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white transition">{{ __('Emergency Services') }}</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white transition">{{ __('Laboratory Tests') }}</a></li>
                        <li><a href="#" class="text-slate-300 hover:text-white transition">{{ __('Mental Health') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">{{ __('Contact Info') }}</h4>
                    <ul class="space-y-2 text-slate-300">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ __('DDU Main Campus') }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            +251-XXX-XXX-XXX
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            clinic@ddu.edu.et
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-teal-800 mt-8 pt-6 text-center">
                <p>© {{ date('Y') }} {{ __('Dire Dawa University Student Clinic | Providing quality healthcare to students') }}</p>
                <p class="text-slate-400 mt-2 text-sm">{{ __('This facility is exclusively for DDU registered students') }}</p>
            </div>
        </div>
    </footer>

</body>
</html>