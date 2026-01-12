@extends('patient.layouts.layout')

@section('title', 'Prescription Details - DDU Clinics')
@section('page-title', 'Prescription Details')
@section('page-subtitle', 'Detailed prescription information')

@section('content')
<div class="animate-slide-up">
    <!-- Action Buttons -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('patient.prescriptions') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Prescriptions</span>
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
            <i class="fas fa-print"></i>
            <span>Print</span>
        </button>
    </div>

    <!-- Prescription Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Prescription Information
            </h3>
            <div class="space-y-3">
                <div>
                    <div class="text-xs text-gray-500 uppercase">Prescription Number</div>
                    <div class="font-mono font-semibold text-gray-800">{{ $prescription->prescription_number }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Date Prescribed</div>
                    <div class="font-medium text-gray-700">{{ $prescription->prescription_date->format('M d, Y') }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Prescribed By</div>
                    <div class="font-medium text-gray-700">{{ $prescription->prescribedBy->name ?? 'N/A' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Status</div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'dispensed' => 'bg-green-100 text-green-800',
                            'partially_dispensed' => 'bg-blue-100 text-blue-800',
                        ];
                        $statusColor = $statusColors[$prescription->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium inline-block">
                        {{ ucfirst(str_replace('_', ' ', $prescription->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-stethoscope text-green-600 mr-2"></i>
                Diagnosis
            </h3>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-800">
                {{ $prescription->diagnosis ?? 'No diagnosis recorded' }}
            </div>
            @if($prescription->notes)
            <div class="mt-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Additional Notes</h4>
                <div class="bg-blue-50 rounded-lg p-4 text-gray-800 whitespace-pre-wrap">
                    {{ $prescription->notes }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Medications -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-pills text-purple-600 mr-2"></i>
            Prescribed Medications
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Medication</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Dosage</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Frequency</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Duration</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Quantity</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Instructions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescription->items as $item)
                    <tr class="border-b">
                        <td class="py-3 px-4 font-medium">{{ $item->medication->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $item->dosage }}</td>
                        <td class="py-3 px-4">{{ $item->frequency }}</td>
                        <td class="py-3 px-4">{{ $item->duration_days }} days</td>
                        <td class="py-3 px-4">{{ $item->quantity }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $item->instructions ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endpush
@endsection
