@extends('reception.layouts.layout')

@section('title', 'Reception Dashboard - DDU Clinics')
@section('page-title', 'Welcome, Receptionist')
@section('page-subtitle', 'Reception Dashboard')

@section('content')
<!-- Quick Actions -->
<div class="mb-8 animate-slide-up">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('reception.register-patient') }}" class="dashboard-card bg-white rounded-xl shadow p-6 flex items-center space-x-4 hover:shadow-lg">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-user-plus text-ddu-primary text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">New Patient</h3>
                <p class="text-gray-600 text-sm">Register a new patient</p>
            </div>
        </a>
        
        <a href="{{ route('reception.schedule-appointments') }}" class="dashboard-card bg-white rounded-xl shadow p-6 flex items-center space-x-4 hover:shadow-lg">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-calendar-check text-ddu-accent text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Book Appointment</h3>
                <p class="text-gray-600 text-sm">Schedule new appointment</p>
            </div>
        </a>
        
        <a href="{{ route('reception.manage-walkin') }}" class="dashboard-card bg-white rounded-xl shadow p-6 flex items-center space-x-4 hover:shadow-lg">
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-walking text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Check Walk-ins</h3>
                <p class="text-gray-600 text-sm">Manage walk-in patients</p>
            </div>
        </a>
    </div>
</div>

<!-- Today's Appointments -->
<div class="mb-8 animate-slide-up" style="animation-delay: 0.1s">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Today's Appointments</h2>
        <a href="{{ route('reception.schedule-appointments') }}" class="text-ddu-primary hover:underline font-medium">View All</a>
    </div>
    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Time</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Student</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Doctor</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayAppointments as $appointment)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>{{ $appointment->patient->full_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $appointment->patient->card_number }}</span>
                        </td>
                        <td class="py-4 px-4">Dr. {{ $appointment->doctor->name ?? 'Unassigned' }}</td>
                        <td class="py-4 px-4">
                            @if($appointment->status == 'completed')
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Completed</span>
                            @elseif($appointment->status == 'cancelled')
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">Cancelled</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst($appointment->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            No appointments for today
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Registrations -->
<div class="animate-slide-up" style="animation-delay: 0.2s">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Recent Registrations</h2>
        <a href="{{ route('reception.search-patients') }}" class="text-ddu-primary hover:underline font-medium">View All</a>
    </div>
    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Student</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Registered On</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPatients as $patient)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>{{ $patient->full_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $patient->card_number }}</span>
                        </td>
                        <td class="py-4 px-4">{{ $patient->created_at->format('M d, Y h:i A') }}</td>
                        <td class="py-4 px-4">{{ $patient->phone ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">
                            No recent registrations
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection