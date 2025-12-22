@extends('layouts.public')

@section('title', 'About Us - DDU Clinic')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 md:py-28 bg-gradient-to-br from-[#4c1d95] via-[#581c87] to-[#d946ef] overflow-hidden">
    <!-- Animated Shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-purple-400 opacity-10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-pink-400 opacity-10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                About <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-pink-200">
                    DDU Clinic
                </span>
            </h1>
            <p class="text-xl text-purple-100 leading-relaxed mb-8">
                Serving the Dire Dawa University community with dedication, compassion, and professional healthcare excellence since 2010.
            </p>
            
            <div class="flex flex-wrap justify-center gap-4">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 flex items-center min-w-[150px]">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-2xl font-bold text-white">10k+</div>
                        <div class="text-xs text-purple-200">Patients</div>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 flex items-center min-w-[150px]">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                        <i class="fas fa-user-md text-white"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-2xl font-bold text-white">50+</div>
                        <div class="text-xs text-purple-200">Staff</div>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 flex items-center min-w-[150px]">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-2xl font-bold text-white">12+</div>
                        <div class="text-xs text-purple-200">Years</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section id="our-story" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-gray-50 transform hover:scale-[1.01] transition-transform duration-500">
                    <img src="https://images.unsplash.com/photo-1538108149393-fbbd81895907?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Clinic History" 
                         class="w-full h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#4c1d95]/60 to-transparent"></div>
                    
                    <div class="absolute bottom-8 left-8 right-8 text-white">
                        <div class="text-sm font-semibold uppercase tracking-wider mb-2 text-purple-200">Established 2010</div>
                        <h3 class="text-2xl font-bold">A Decade of Excellence</h3>
                    </div>
                </div>
                
                <!-- Floating Badge -->
                <div class="absolute -bottom-10 -right-10 bg-white p-6 rounded-2xl shadow-xl max-w-xs hidden md:block border border-gray-100">
                    <p class="text-gray-600 italic text-sm">
                        "Dedicated to fostering a healthy campus environment where students can thrive academically and personally."
                    </p>
                    <div class="mt-4 flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-200 mr-3"></div>
                        <div>
                            <div class="font-bold text-gray-900">Dr. Abebe Kebede</div>
                            <div class="text-xs text-gray-500">Clinic Director</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <span class="text-[#d946ef] font-bold tracking-wider uppercase text-sm mb-2 block">Our Story</span>
                <h2 class="text-4xl font-bold text-gray-900 mb-6 leading-tight">
                    A Legacy of 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4c1d95] to-[#d946ef]">
                        Campus Healthcare
                    </span>
                </h2>
                
                <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                    <p>
                        Founded with a vision to provide accessible healthcare to the growing student population, 
                        DDU Clinic has evolved from a small infirmary to a comprehensive primary care center.
                    </p>
                    <p>
                        We understand the unique health challenges faced by students - from stress and mental health 
                        concerns to sports injuries and infectious diseases. Our multidisciplinary team works 
                        collaboratively to address these needs holistically.
                    </p>
                    <p>
                        Today, we are proud to be an integral part of the Dire Dawa University community, 
                        promoting wellness and health education alongside clinical treatment.
                    </p>
                </div>
                
                <div class="mt-10">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 bg-[#4c1d95] text-white rounded-lg font-bold shadow-lg hover:bg-[#3b1575] transition-all duration-300">
                        Join Our Community
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-20 bg-gray-50 relative overflow-hidden">
    <!-- Decorative Circle -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Mission Card -->
            <div class="bg-white rounded-3xl p-10 shadow-xl border border-gray-100 relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full transition-transform duration-500 group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#4c1d95] to-[#6d28d9] flex items-center justify-center mb-8 shadow-lg">
                        <i class="fas fa-bullseye text-2xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To maintain and improve the health and well-being of the university community by providing 
                        accessible, high-quality, and patient-centered medical care, health education, and public health services.
                    </p>
                </div>
            </div>
            
            <!-- Vision Card -->
            <div class="bg-white rounded-3xl p-10 shadow-xl border border-gray-100 relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500">
                <div class="absolute top-0 right-0 w-32 h-32 bg-pink-50 rounded-bl-full transition-transform duration-500 group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#d946ef] to-pink-600 flex items-center justify-center mb-8 shadow-lg">
                        <i class="fas fa-globe text-2xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Vision</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To be a model of excellence in student health services, creating a healthy campus environment 
                        that empowers students to achieve their full academic and personal potential.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Core Values</h2>
            <p class="text-gray-600 text-lg">The principles that guide our care and interactions</p>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#4c1d95] transition-colors duration-300">
                    <i class="fas fa-heart text-3xl text-[#4c1d95] group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Compassion</h3>
                <p class="text-gray-600">We treat every patient with kindness, empathy, and respect.</p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#4c1d95] transition-colors duration-300">
                    <i class="fas fa-shield-alt text-3xl text-[#4c1d95] group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Integrity</h3>
                <p class="text-gray-600">We adhere to the highest ethical and professional standards.</p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#4c1d95] transition-colors duration-300">
                    <i class="fas fa-star text-3xl text-[#4c1d95] group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Excellence</h3>
                <p class="text-gray-600">We strive for continuous improvement in all our services.</p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#4c1d95] transition-colors duration-300">
                    <i class="fas fa-hand-holding-medical text-3xl text-[#4c1d95] group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inclusivity</h3>
                <p class="text-gray-600">We provide non-judgmental care to all members of our community.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Preview -->
<section class="py-20 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-gray-600 text-lg">Experienced professionals dedicated to your health</p>
        </div>
        
        <div class="relative max-w-5xl mx-auto bg-white rounded-3xl p-1 shadow-xl">
            <div class="bg-gradient-to-r from-[#4c1d95] to-[#d946ef] rounded-[22px] p-12 text-center text-white">
                <h3 class="text-2xl font-bold mb-4">Our Medical Staff</h3>
                <p class="text-lg text-purple-100 max-w-2xl mx-auto mb-8">
                    Our team consists of board-certified physicians, nurse practitioners, registered nurses, 
                    pharmacists, and laboratory technicians working together to provide comprehensive care.
                </p>
                <div class="flex justify-center -space-x-4 mb-8">
                    <div class="w-16 h-16 rounded-full border-4 border-[#4c1d95] bg-gray-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=12" alt="Staff"></div>
                    <div class="w-16 h-16 rounded-full border-4 border-[#4c1d95] bg-gray-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=23" alt="Staff"></div>
                    <div class="w-16 h-16 rounded-full border-4 border-[#4c1d95] bg-gray-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=34" alt="Staff"></div>
                    <div class="w-16 h-16 rounded-full border-4 border-[#4c1d95] bg-gray-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=45" alt="Staff"></div>
                    <div class="w-16 h-16 rounded-full border-4 border-[#4c1d95] bg-white text-[#4c1d95] flex items-center justify-center font-bold text-xl">+45</div>
                </div>
                <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-white text-[#4c1d95] rounded-lg font-bold hover:bg-gray-100 transition-colors">
                    Book Appointment
                </a>
            </div>
        </div>
    </div>
</section>
@endsection