@extends('doctor.layouts.layout')

@section('title', 'Request Lab Test - DDU Clinics')
@section('page-title', 'Request Laboratory Test')
@section('page-subtitle', 'Order tests for patients')

@section('content')
<div class="animate-slade-up">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Select Patient & Tests</h2>
        
        <form action="{{ route('doctor.store-lab-request') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Patient Selection -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2">Patient Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Select Patient *</label>
                        <select name="patient_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                            <option value="">Choose patient</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">
                                {{ $patient->full_name }} ({{ $patient->card_number ?? 'N/A' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Link to Appointment (optional)</label>
                        <select name="appointment_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                            <option value="">Select today's appointment</option>
                            @foreach($appointments as $appt)
                            <option value="{{ $appt->id }}">
                                {{ $appt->patient->full_name }} — {{ $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') : '' }} ({{ ucfirst($appt->status) }})
                            </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Only today's scheduled/in-progress appointments are shown.</p>
                    </div>
                </div>
            </div>
            
            <!-- Test Selection -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2">Test Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Test Type *</label>
                        <input type="text" name="test_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., Complete Blood Count (CBC)" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Due Date (optional)</label>
                        <input type="date" name="due_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" value="{{ now()->toDateString() }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Test Description</label>
                        <textarea name="test_description" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Add specific test panels, samples, or methodology..."></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Clinical Notes</label>
                        <textarea name="clinical_notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Symptoms, suspected diagnosis, or relevant findings..."></textarea>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Priority *</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach(['normal' => 'Routine (24-48h)', 'urgent' => 'Urgent (2-6h)', 'stat' => 'STAT (≤1h)'] as $value => $label)
                        <label class="flex items-start space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300">
                            <input type="radio" name="priority" value="{{ $value }}" class="mt-1" {{ $value === 'normal' ? 'checked' : '' }}>
                            <div>
                                <div class="font-medium text-gray-800">{{ ucfirst($value) }}</div>
                                <div class="text-gray-600 text-sm">{{ $label }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('doctor.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Submit Lab Request</span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Recent Lab Requests -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Recent Lab Requests</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Request ID</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Patient</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Test</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Date</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Priority</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRequests as $req)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-gray-800">{{ $req->request_number }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>{{ $req->patient->full_name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">{{ $req->test_type }}</span>
                        </td>
                        <td class="py-4 px-6">
                            {{ $req->requested_date ? \Carbon\Carbon::parse($req->requested_date)->format('M d, Y') : $req->created_at->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $priorityColors = [
                                    'urgent' => 'bg-red-100 text-red-800',
                                    'stat' => 'bg-red-100 text-red-800',
                                    'normal' => 'bg-yellow-100 text-yellow-800',
                                ];
                                $pColor = $priorityColors[$req->priority] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $pColor }} py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst($req->priority) }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $sColor = $statusColors[$req->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $sColor }} py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">No lab requests yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection