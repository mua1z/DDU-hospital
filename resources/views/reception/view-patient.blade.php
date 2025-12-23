@extends('reception.layouts.layout')

@section('title', 'View Patient - DDU Clinics')
@section('page-title', 'Patient Information')
@section('page-subtitle', $patient->full_name)

@section('content')
<div class="animate-slide-up">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Patient Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Patient Details</h2>
                    <a href="{{ route('reception.search-patients') }}" class="text-ddu-primary hover:underline">Back to Search</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Full Name</label>
                        <p class="text-gray-800 font-semibold">{{ $patient->full_name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Card Number</label>
                        <p class="text-gray-800 font-semibold">{{ $patient->card_number }}</p>
                    </div>
                    
                    @if($patient->date_of_birth)
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Date of Birth</label>
                        <p class="text-gray-800">{{ $patient->date_of_birth->format('M d, Y') }} ({{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years)</p>
                    </div>
                    @endif
                    
                    @if($patient->gender)
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Gender</label>
                        <p class="text-gray-800">{{ ucfirst($patient->gender) }}</p>
                    </div>
                    @endif
                    
                    @if($patient->phone)
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Phone</label>
                        <p class="text-gray-800">{{ $patient->phone }}</p>
                    </div>
                    @endif
                    
                    @if($patient->email)
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Email</label>
                        <p class="text-gray-800">{{ $patient->email }}</p>
                    </div>
                    @endif
                    
                    @if($patient->address)
                    <div class="md:col-span-2">
                        <label class="block text-gray-600 text-sm font-medium mb-1">Address</label>
                        <p class="text-gray-800">{{ $patient->address }}</p>
                    </div>
                    @endif
                    
                    @if($patient->emergency_contact_name)
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Emergency Contact</label>
                        <p class="text-gray-800">{{ $patient->emergency_contact_name }}</p>
                        @if($patient->emergency_contact_phone)
                        <p class="text-gray-600 text-sm">{{ $patient->emergency_contact_phone }}</p>
                        @endif
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Registered On</label>
                        <p class="text-gray-800">{{ $patient->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                
                @if($patient->allergies)
                <div class="mt-6 pt-6 border-t">
                    <label class="block text-gray-600 text-sm font-medium mb-2">Known Allergies</label>
                    <p class="text-gray-800">{{ $patient->allergies }}</p>
                </div>
                @endif
                
                @if($patient->medical_history)
                <div class="mt-6 pt-6 border-t">
                    <label class="block text-gray-600 text-sm font-medium mb-2">Medical History</label>
                    <p class="text-gray-800">{{ $patient->medical_history }}</p>
                </div>
                @endif
            </div>
            
            <!-- Medical Records History -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Medical Document History</h2>
                @if($patient->medicalRecords->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-ddu-light">
                            <tr>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Doctor</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Diagnosis</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->medicalRecords as $record)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $record->visit_date->format('M d, Y') }}</td>
                                <td class="py-3 px-4">{{ $record->doctor->name ?? 'Unknown' }}</td>
                                <td class="py-3 px-4">
                                    <div class="text-sm">
                                        {{ implode(', ', $record->diagnosis ?? []) }}
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                     <!-- Receptionist usually has read-only access or limited edit rights. 
                                          We can add a View/Edit button if required by "update or edit by doctors and Reception".
                                          For now, let's assume read-only or a future edit link. -->
                                     <span class="text-gray-500 text-sm">View Only</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-600 text-center py-4">No medical records found.</p>
                @endif
            </div>

            <!-- Appointments History -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Appointment History</h2>
                @if($patient->appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-ddu-light">
                            <tr>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Time</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Doctor</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->appointments->take(10) as $appointment)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                <td class="py-3 px-4">{{ $appointment->doctor->name ?? 'Not Assigned' }}</td>
                                <td class="py-3 px-4">
                                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-600 text-center py-4">No appointment history</p>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div>
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('reception.schedule-appointments') }}?patient_id={{ $patient->id }}" class="block w-full px-4 py-3 bg-ddu-primary text-white rounded-lg hover:bg-blue-700 transition text-center">
                        <i class="fas fa-calendar-alt mr-2"></i> Schedule Appointment
                    </a>
                    <a href="{{ route('reception.search-patients') }}" class="block w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center">
                        <i class="fas fa-search mr-2"></i> Search Patients
                    </a>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistics</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Total Appointments</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $patient->appointments->count() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Prescriptions</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $patient->prescriptions->count() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Lab Tests</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $patient->labRequests->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

