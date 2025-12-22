@extends('layouts.public')

@section('title', 'Contact Us - DDU Clinic')

@section('content')
<section class="py-20 bg-gradient-to-br from-purple-50 to-pink-50 min-h-[80vh] flex items-center relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-200 rounded-full blur-3xl opacity-30 -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-pink-200 rounded-full blur-3xl opacity-30 translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="bg-[#4c1d95] rounded-3xl overflow-hidden shadow-2xl relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10 pattern-dots"></div>

            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-12 text-white relative">
                    <h2 class="text-3xl font-bold mb-6">Get in Touch</h2>
                    <p class="text-purple-100 mb-10 text-lg">Have questions or need assistance? Reach out to our reception desk or visit us on campus.</p>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-white shrink-0 border border-white/20">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div class="ml-6">
                                <h4 class="font-bold text-lg mb-1">Location</h4>
                                <p class="text-purple-100">Dire Dawa University Main Campus<br>Building 15, Ground Floor</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-white shrink-0 border border-white/20">
                                <i class="fas fa-phone-alt text-xl"></i>
                            </div>
                            <div class="ml-6">
                                <h4 class="font-bold text-lg mb-1">Phone</h4>
                                <p class="text-purple-100">+251 251 11 11 11</p>
                                <p class="text-purple-200 text-sm">Mon-Fri, 8am - 8pm</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-white shrink-0 border border-white/20">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div class="ml-6">
                                <h4 class="font-bold text-lg mb-1">Email</h4>
                                <p class="text-purple-100">clinic@ddu.edu.et</p>
                                <p class="text-purple-200 text-sm">We reply within 24 hours</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative bg-gray-900 min-h-[400px] lg:min-h-full">
                    <!-- Simulated Map -->
                    <div class="absolute inset-0 bg-gray-800 flex items-center justify-center overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Map Location" class="w-full h-full object-cover opacity-60 group-hover:opacity-40 transition-opacity duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8 text-center">
                            <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-[#4c1d95] rounded-xl font-bold hover:bg-purple-50 transition-colors shadow-lg">
                                <i class="fas fa-location-arrow mr-2"></i>
                                View on Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
