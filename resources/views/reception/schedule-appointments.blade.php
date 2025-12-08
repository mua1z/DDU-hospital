@extends('reception.layouts.layout')

@section('title', 'Schedule Appointments - DDU Clinics')
@section('page-title', 'Schedule Appointments')
@section('page-subtitle', 'Manage patient appointments')

@section('content')
<div class="animate-slide-up">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Appointment Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">New Appointment</h2>
                
                <form action="{{ route('reception.store-appointment') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Patient *</label>
                            <select name="patient_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->full_name }} ({{ $patient->card_number }})</option>
                                @endforeach
                            </select>
                            @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Doctor</label>
                            <select name="doctor_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Date *</label>
                            <input type="date" name="appointment_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" value="{{ old('appointment_date', now()->format('Y-m-d')) }}" required>
                            @error('appointment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Appointment Time *</label>
                            <input type="time" name="appointment_time" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" value="{{ old('appointment_time') }}" required>
                            @error('appointment_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Type *</label>
                            <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                                <option value="appointment" {{ old('type') == 'appointment' ? 'selected' : '' }}>Appointment</option>
                                <option value="walk_in" {{ old('type') == 'walk_in' ? 'selected' : '' }}>Walk-In</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Reason</label>
                            <input type="text" name="reason" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="Reason for visit" value="{{ old('reason') }}">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Notes</label>
                        <textarea name="notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-4 border-t">
                        <a href="{{ route('reception.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-blue-700 transition">
                            Schedule Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Recent Appointments -->
        <div>
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Appointments</h2>
                <div class="space-y-3">
                    @forelse($appointments->take(5) as $appointment)
                    <div class="p-3 border border-gray-200 rounded-lg">
                        <div class="font-medium text-gray-800">{{ $appointment->patient->full_name }}</div>
                        <div class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M d') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $appointment->doctor->name ?? 'No doctor' }}</div>
                    </div>
                    @empty
                    <p class="text-gray-600 text-sm text-center py-4">No recent appointments</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- All Appointments Table -->
    <div class="mt-8 animate-slide-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">All Appointments</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-ddu-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Appointment #</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Patient</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date & Time</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Doctor</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Type</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-mono text-sm">{{ $appointment->appointment_number }}</td>
                            <td class="py-3 px-4">{{ $appointment->patient->full_name }}</td>
                            <td class="py-3 px-4">
                                {{ $appointment->appointment_date->format('M d, Y') }}<br>
                                <span class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                            </td>
                            <td class="py-3 px-4">{{ $appointment->doctor->name ?? 'Not Assigned' }}</td>
                            <td class="py-3 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $appointment->type)) }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $statusColors = [
                                        'scheduled' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusColor = $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No appointments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

