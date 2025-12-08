@extends('reception.layouts.layout')

@section('title', 'Manage Walk-Ins - DDU Clinics')
@section('page-title', 'Manage Walk-In Patients')
@section('page-subtitle', 'Today\'s Walk-In Appointments')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Today's Walk-In Patients</h2>
            <a href="{{ route('reception.schedule-appointments') }}" class="px-4 py-2 bg-ddu-primary text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> New Walk-In
            </a>
        </div>
        
        @if($walkIns->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Time</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Patient</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Doctor</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Reason</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($walkIns as $walkIn)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($walkIn->appointment_time)->format('h:i A') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>{{ $walkIn->patient->full_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $walkIn->patient->card_number }}</span>
                        </td>
                        <td class="py-4 px-4">{{ $walkIn->doctor->name ?? 'Not Assigned' }}</td>
                        <td class="py-4 px-4">{{ $walkIn->reason ?? 'N/A' }}</td>
                        <td class="py-4 px-4">
                            @php
                                $statusColors = [
                                    'scheduled' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-gray-100 text-gray-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusColor = $statusColors[$walkIn->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $walkIn->status)) }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('reception.view-patient', $walkIn->patient->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-walking text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No walk-in patients for today</p>
            <a href="{{ route('reception.schedule-appointments') }}" class="mt-4 inline-block px-6 py-2 bg-ddu-primary text-white rounded-lg hover:bg-blue-700 transition">
                Schedule Walk-In
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

