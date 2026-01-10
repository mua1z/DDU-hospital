@extends('patient.layouts.layout')

@section('title', 'My Appointments - Patient Portal')
@section('page-title', 'My Appointments')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-bold text-gray-800">Appointment History</h2>
        <a href="{{ route('patient.book-appointment') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow-md">
            <i class="fas fa-plus mr-1"></i> Book New
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-semibold">Date & Time</th>
                    <th class="p-4 font-semibold">Doctor</th>
                    <th class="p-4 font-semibold">Reason</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">
                                    {{ substr($appointment->doctor->name ?? 'D', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-700">Dr. {{ $appointment->doctor->name ?? 'Unassigned' }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-gray-600 text-sm max-w-xs truncate">
                            {{ $appointment->reason ?? 'Checkup' }}
                        </td>
                        <td class="p-4">
                            @php
                                $statusClasses = [
                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                ];
                                $class = $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $class }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <button class="text-gray-400 hover:text-blue-600 transition">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            No appointments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
