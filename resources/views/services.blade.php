@extends('layouts.public')

@section('title', 'Our Services - DDU Clinic')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 md:py-28 bg-gradient-to-br from-[#4c1d95] via-[#581c87] to-[#d946ef] overflow-hidden">
    <!-- Animated Circles -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute top-10 left-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-400 opacity-10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <span class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-sm text-purple-100 text-sm font-semibold mb-6 border border-white/20">
            Comprehensive Campus Care
        </span>
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
            Healthcare Services <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-pink-200">
                Tailored for Students
            </span>
        </h1>
        <p class="text-xl text-purple-100 max-w-2xl mx-auto mb-10">
            Expert medical care, convenient access, and student-friendly services. 
            We are here to support your health throughout your academic journey.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#all-services" class="px-8 py-4 bg-white text-[#4c1d95] rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all duration-300">
                View All Services
            </a>
            <a href="{{ route('login') }}" class="px-8 py-4 bg-[#7e22ce] text-white rounded-xl font-bold shadow-lg hover:bg-[#6b21a8] transition-all duration-300 border border-purple-400/30">
                Book Appointment
            </a>
        </div>
    </div>
    
    <!-- Wave Separator -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-[calc(100%+1.3px)] h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-white"></path>
        </svg>
    </div>
</section>

<!-- Services Grid -->
<section id="all-services" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Service 1: General Consultation -->
            <div class="group relative bg-gradient-to-b from-white to-purple-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#4c1d95]/5 to-[#d946ef]/5 rounded-bl-full transition-all duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4c1d95] to-[#d946ef] flex items-center justify-center mb-8 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-stethoscope text-2xl text-white"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    General Consultation
                    <i class="fas fa-arrow-right text-[#d946ef] ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                </h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Primary care for all your potential health concerns. Our expert doctors provide diagnoses, checkups, and referrals.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-[#4c1d95] mr-2"></i> Routine Checkups
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-[#4c1d95] mr-2"></i> Illness Diagnosis
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-[#4c1d95] mr-2"></i> Health Certificates
                    </li>
                </ul>
                
                <a href="{{ route('login') }}" class="inline-block w-full text-center py-3 rounded-xl bg-white border-2 border-[#4c1d95]/10 text-[#4c1d95] font-semibold hover:bg-[#4c1d95] hover:text-white transition-colors duration-300">
                    Book Now
                </a>
            </div>

            <!-- Service 2: Laboratory -->
            <div class="group relative bg-gradient-to-b from-white to-purple-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-pink-50 to-purple-50 rounded-bl-full transition-all duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-600 to-purple-600 flex items-center justify-center mb-8 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-flask text-2xl text-white"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    Laboratory
                    <i class="fas fa-arrow-right text-pink-500 ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                </h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Advanced diagnostic testing services on campus with quick turnaround times for accurate results.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-pink-600 mr-2"></i> Blood Tests
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-pink-600 mr-2"></i> Urinalysis
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-pink-600 mr-2"></i> Parasitology
                    </li>
                </ul>

                <a href="{{ route('login') }}" class="inline-block w-full text-center py-3 rounded-xl bg-white border-2 border-pink-600/10 text-pink-700 font-semibold hover:bg-pink-600 hover:text-white transition-colors duration-300">
                    Book Test
                </a>
            </div>

            <!-- Service 3: Pharmacy -->
            <div class="group relative bg-gradient-to-b from-white to-purple-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-bl-full transition-all duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4c1d95] to-indigo-600 flex items-center justify-center mb-8 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-pills text-2xl text-white"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    Pharmacy
                    <i class="fas fa-arrow-right text-[#4c1d95] ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                </h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Fully stocked campus pharmacy providing prescription and over-the-counter medications.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-[#4c1d95] mr-2"></i> Prescription Meds
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-[#4c1d95] mr-2"></i> Consulting
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-[#4c1d95] mr-2"></i> First Aid Supplies
                    </li>
                </ul>

                <a href="{{ route('login') }}" class="inline-block w-full text-center py-3 rounded-xl bg-white border-2 border-[#4c1d95]/10 text-[#4c1d95] font-semibold hover:bg-[#4c1d95] hover:text-white transition-colors duration-300">
                    Visit Pharmacy
                </a>
            </div>

            <!-- Service 4: Emergency Care -->
            <div class="group relative bg-gradient-to-b from-white to-red-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-50 to-pink-50 rounded-bl-full transition-all duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center mb-8 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-ambulance text-2xl text-white"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    Emergency Care
                    <i class="fas fa-arrow-right text-red-500 ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                </h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    24/7 emergency response for urgent medical situations requiring immediate attention.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-red-500 mr-2"></i> 24/7 Availability
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-red-500 mr-2"></i> Trauma Care
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-red-500 mr-2"></i> Ambulance Access
                    </li>
                </ul>

                <a href="{{ route('login') }}" class="inline-block w-full text-center py-3 rounded-xl bg-white border-2 border-red-100 text-red-600 font-semibold hover:bg-red-500 hover:text-white transition-colors duration-300">
                    Emergency Info
                </a>
            </div>

            <!-- Service 5: Mental Health -->
            <div class="group relative bg-gradient-to-b from-white to-green-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-50 to-teal-50 rounded-bl-full transition-all duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mb-8 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-brain text-2xl text-white"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    Mental Health
                    <i class="fas fa-arrow-right text-emerald-500 ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                </h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Counseling and psychological support to help students manage stress and mental well-being.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-emerald-500 mr-2"></i> Counseling
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-emerald-500 mr-2"></i> Therapy Sessions
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-emerald-500 mr-2"></i> Stress Management
                    </li>
                </ul>

                <a href="{{ route('login') }}" class="inline-block w-full text-center py-3 rounded-xl bg-white border-2 border-emerald-100 text-emerald-600 font-semibold hover:bg-emerald-500 hover:text-white transition-colors duration-300">
                    Book Session
                </a>
            </div>

            <!-- Service 6: Dental Care -->
            <div class="group relative bg-gradient-to-b from-white to-blue-50 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full transition-all duration-500 group-hover:scale-150"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-8 shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <i class="fas fa-tooth text-2xl text-white"></i>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    Dental Care
                    <i class="fas fa-arrow-right text-blue-500 ml-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                </h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Basic dental services including checkups, cleaning, and pain management.
                </p>
                
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i> Checkups
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i> Cleaning
                    </li>
                    <li class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-check-circle text-blue-500 mr-2"></i> Minor Procedures
                    </li>
                </ul>

                <a href="{{ route('login') }}" class="inline-block w-full text-center py-3 rounded-xl bg-white border-2 border-blue-100 text-blue-600 font-semibold hover:bg-blue-500 hover:text-white transition-colors duration-300">
                    Book Appointment
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-gray-600 text-lg">Simple steps to access healthcare at DDU</p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center relative">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-[#4c1d95]/10 mb-6 z-10 relative">
                    <span class="text-2xl font-bold text-[#4c1d95]">1</span>
                </div>
                <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 -z-0"></div>
                <h3 class="font-bold text-lg mb-2">Login</h3>
                <p class="text-sm text-gray-500">Access the portal</p>
            </div>
            
            <div class="text-center relative">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-[#4c1d95]/10 mb-6 z-10 relative">
                    <span class="text-2xl font-bold text-[#4c1d95]">2</span>
                </div>
                <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 -z-0"></div>
                <h3 class="font-bold text-lg mb-2">Book</h3>
                <p class="text-sm text-gray-500">Choose service & time</p>
            </div>
            
            <div class="text-center relative">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-[#4c1d95]/10 mb-6 z-10 relative">
                    <span class="text-2xl font-bold text-[#4c1d95]">3</span>
                </div>
                <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-gray-200 -z-0"></div>
                <h3 class="font-bold text-lg mb-2">Visit</h3>
                <p class="text-sm text-gray-500">Come to the clinic</p>
            </div>
            
            <div class="text-center relative">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-[#4c1d95] to-[#d946ef] text-white rounded-full flex items-center justify-center shadow-lg mb-6 z-10 relative">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Care</h3>
                <p class="text-sm text-gray-500">Get treated</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-[#4c1d95] to-[#d946ef] text-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Need specialist care?</h2>
        <p class="text-purple-100 text-lg mb-10">
            If you need a service not listed here, please contact our reception desk for a referral 
            to partner hospitals in Dire Dawa.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ url('/contact') }}" class="px-8 py-4 bg-white text-[#4c1d95] rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-purple-50 transition-all duration-300">
                Contact Reception
            </a>
            <a href="tel:+1234567890" class="px-8 py-4 bg-[#4c1d95]/50 backdrop-blur-sm border border-white/30 text-white rounded-xl font-bold hover:bg-[#4c1d95]/70 transition-all duration-300">
                Call Now
            </a>
        </div>
    </div>
</section>
@endsection