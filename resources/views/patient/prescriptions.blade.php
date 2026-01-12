@extends('patient.layouts.layout')

@section('title', 'My Prescriptions - DDU Clinics')
@section('page-title', 'My Prescriptions')
@section('page-subtitle', 'View your prescribed medications')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">All Prescriptions</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Prescription #</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Prescribed By</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Diagnosis</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <span class="font-mono font-medium text-gray-800">{{ $prescription->prescription_number }}</span>
                        </td>
                        <td class="py-4 px-4">
                            {{ $prescription->prescription_date->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-4">
                            {{ $prescription->prescribedBy->name ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-4">
                            {{ Str::limit($prescription->diagnosis, 40) }}
                        </td>
                        <td class="py-4 px-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'dispensed' => 'bg-green-100 text-green-800',
                                    'partially_dispensed' => 'bg-blue-100 text-blue-800',
                                ];
                                $statusColor = $statusColors[$prescription->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ ucfirst(str_replace('_', ' ', $prescription->status)) }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('patient.prescription-details', $prescription->id) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                <i class="fas fa-eye mr-1"></i>
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            <i class="fas fa-prescription text-3xl text-gray-300 mb-2"></i>
                            <p>No prescriptions found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection
