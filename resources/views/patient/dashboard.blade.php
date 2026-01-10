@extends('patient.layouts.layout')

@section('title', 'Dashboard - Patient Portal')
@section('page-title', 'Patient Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Profile Summary Card -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 dashboard-card h-full">
            <div class="text-center mb-6">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-3xl font-bold shadow-inner">
                    {{ substr($patient->full_name, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $patient->full_name }}</h3>
                <p class="text-sm text-gray-500">{{ $patient->card_number }}</p>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500 text-sm">Date of Birth</span>
                    <span class="font-medium">{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500 text-sm">Gender</span>
                    <span class="font-medium capitalize">{{ $patient->gender ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500 text-sm">Blood Type</span>
                    <span class="font-medium text-red-500">{{ $patient->blood_type ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500 text-sm">Phone</span>
                    <span class="font-medium">{{ $patient->phone ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Emergency Contact</h4>
                <div class="bg-red-50 p-3 rounded-lg border border-red-100">
                    <p class="text-sm font-medium text-red-800">{{ $patient->emergency_contact_name ?? 'Not Set' }}</p>
                    <p class="text-xs text-red-600">{{ $patient->emergency_contact_phone ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="md:col-span-2 space-y-6">
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg shadow-blue-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm">Upcoming Appointments</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $upcomingAppointments->count() }}</h3>
                    </div>
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-calendar-check text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Visits</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $patient->medicalRecords()->count() }}</h3>
                    </div>
                    <div class="bg-gray-100 p-2 rounded-lg text-gray-500">
                        <i class="fas fa-notes-medical text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Next Upcoming Appointment</h3>
                <a href="{{ route('patient.my-appointments') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
            </div>
            
            <div class="p-5">
                @if($upcomingAppointments->count() > 0)
                    @foreach($upcomingAppointments as $appointment)
                        <div class="flex items-start space-x-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                            <div class="flex-shrink-0 bg-blue-50 w-16 h-16 rounded-xl flex flex-col items-center justify-center text-blue-600 border border-blue-100">
                                <span class="text-xs uppercase font-bold">{{ $appointment->appointment_date->format('M') }}</span>
                                <span class="text-xl font-bold leading-none">{{ $appointment->appointment_date->format('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800">Consultation with {{ $appointment->doctor ? $appointment->doctor->name : 'Doctor' }}</h4>
                                <div class="flex items-center text-sm text-gray-500 mt-1 space-x-3">
                                    <span><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                                    <span><i class="fas fa-map-marker-alt mr-1"></i> Clinic Room 1</span>
                                </div>
                                @if($appointment->reason)
                                    <p class="text-sm text-gray-600 mt-2 bg-gray-50 p-2 rounded">Reason: {{ $appointment->reason }}</p>
                                @endif
                            </div>
                            <div>
                                <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                            <i class="far fa-calendar-times text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No upcoming appointments</p>
                        <a href="{{ route('patient.book-appointment') }}" class="inline-block mt-3 text-blue-600 font-medium hover:underline">Book an Appointment</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Medical History -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Recent Medical History</h3>
                <a href="{{ route('patient.medical-records') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View Full History</a>
            </div>
            
            <div class="divide-y divide-gray-50">
                @forelse($recentRecords as $record)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">{{ $record->created_at->format('M d, Y') }}</span>
                            <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $record->diagnosis_type ?? 'General' }}</span>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1">
                            {{ is_array($record->diagnosis) ? implode(', ', $record->diagnosis) : ($record->diagnosis ?? 'Checkup') }}
                        </h4>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($record->treatment_plan ?? $record->description, 100) }}</p>
                        <div class="mt-3 flex items-center text-xs text-gray-400">
                            <i class="fas fa-user-md mr-1"></i> Dr. {{ $record->doctor ? $record->doctor->name : 'Unknown' }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>No medical records found.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
