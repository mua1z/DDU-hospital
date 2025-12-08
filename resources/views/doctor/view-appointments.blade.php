@extends('doctor.layouts.layout')

@section('title', 'View Appointments - DDU Clinics')
@section('page-title', 'Appointments Schedule')
@section('page-subtitle', 'Manage patient appointments')

@section('content')
<div class="animate-slide-up">
    <!-- Appointment Filters -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <button class="px-4 py-2 bg-ddu-primary text-white rounded-lg font-medium">Today</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Tomorrow</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">This Week</button>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search patient..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button class="px-4 py-2 border border-ddu-primary text-ddu-primary rounded-lg hover:bg-green-50">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>
    </div>
    
    <!-- Appointments Calendar View -->
    <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Appointments for Today ({{ \Carbon\Carbon::now()->format('M d, Y') }})</h2>
        </div>
        
        <div class="divide-y">
            @forelse($appointments as $appointment)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                        <div class="w-14 h-14 rounded-full {{ $appointment['bgColor'] }} flex items-center justify-center">
                            <i class="{{ $appointment['icon'] }} {{ $appointment['textColor'] }} text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $appointment['patient'] }}</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">
                                    <i class="fas fa-id-card mr-1"></i> {{ $appointment['cardNo'] }}
                                </span>
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">
                                    <i class="fas fa-user-clock mr-1"></i> {{ $appointment['age'] }} years
                                </span>
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">
                                    <i class="fas fa-venus-mars mr-1"></i> {{ $appointment['gender'] }}
                                </span>
                            </div>
                            <p class="text-gray-600 mt-2">{{ $appointment['symptoms'] }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col lg:items-end space-y-3">
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-800">{{ $appointment['time'] }}</div>
                            <div class="text-gray-600">{{ $appointment['duration'] }}</div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <span class="{{ $appointment['statusClass'] }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ $appointment['status'] }}
                            </span>
                            @if($appointment['priority'] === 'high')
                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">
                                <i class="fas fa-exclamation-circle mr-1"></i> Urgent
                            </span>
                            @endif
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('doctor.document-history') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                                <i class="fas fa-clipboard-check"></i>
                                <span>Start Consultation</span>
                            </a>
                            <button class="p-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                No appointments scheduled for today
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Upcoming Appointments -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tomorrow's Appointments -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Tomorrow's Schedule</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($tomorrowAppointments as $appt)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-green-300 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $appt['patient'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $appt['reason'] }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-gray-800">{{ $appt['time'] }}</div>
                            <div class="text-gray-600 text-sm">{{ $appt['type'] }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">No appointments scheduled for tomorrow</div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Appointment Statistics -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Weekly Statistics</h2>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Completed</span>
                            <span class="font-bold text-gray-800">42</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Pending</span>
                            <span class="font-bold text-gray-800">18</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 30%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Cancelled</span>
                            <span class="font-bold text-gray-800">5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 8%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">No-show</span>
                            <span class="font-bold text-gray-800">3</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-500 h-2 rounded-full" style="width: 5%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection