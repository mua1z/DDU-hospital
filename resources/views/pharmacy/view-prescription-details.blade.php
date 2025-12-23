@extends('pharmacy.layouts.layout')

@section('title', 'Prescription Details - DDU Clinics')
@section('page-title', 'Prescription Details')
@section('page-subtitle', 'View prescription information')

@section('content')
<div class="animate-slade-up">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Prescription Details -->
        <div class="md:col-span-3 lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Prescription #{{ $prescription->prescription_number }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($prescription->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($prescription->status == 'dispensed') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $prescription->status)) }}
                    </span>
                </div>
                
                <!-- Patient Information -->
                <div class="space-y-4 mb-8">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-user-injured mr-2"></i> Patient Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Patient Name</label>
                            <div class="font-medium text-gray-900">{{ $prescription->patient->full_name }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Card No.</label>
                            <div class="font-medium text-gray-900">{{ $prescription->patient->card_number }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Age & Gender</label>
                            <div class="font-medium text-gray-900">
                                {{ $prescription->patient->date_of_birth ? \Carbon\Carbon::parse($prescription->patient->date_of_birth)->age . ' years' : 'N/A' }}, 
                                {{ ucfirst($prescription->patient->gender ?? 'N/A') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Prescribed By -->
                <div class="space-y-4 mb-8">
                     <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-user-md mr-2"></i> Prescribed By
                    </h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Doctor Name</label>
                            <div class="font-medium text-gray-900">Dr. {{ $prescription->prescribedBy->name ?? 'Unknown' }}</div>
                        </div>
                         <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Date</label>
                            <div class="font-medium text-gray-900">{{ $prescription->prescription_date->format('M d, Y') }}</div>
                        </div>
                     </div>
                </div>

                <!-- Medication Items -->
                <div class="space-y-4 mb-8">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-pills mr-2"></i> Medications
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Medication</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Dosage</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Freq</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Duration</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Qty</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Instructions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($prescription->items as $item)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $item->medication->name }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->dosage }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->frequency }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->duration_days }} days</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-gray-500 text-xs italic">{{ $item->instructions ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                 <!-- Notes -->
                 @if($prescription->notes || $prescription->diagnosis)
                <div class="space-y-4">
                     <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-sticky-note mr-2"></i> Clinical Notes
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         @if($prescription->diagnosis)
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Diagnosis</label>
                            <div class="bg-gray-50 p-3 rounded-lg text-gray-700 text-sm">{{ $prescription->diagnosis }}</div>
                        </div>
                        @endif
                        @if($prescription->notes)
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Notes</label>
                            <div class="bg-gray-50 p-3 rounded-lg text-gray-700 text-sm">{!! nl2br(e($prescription->notes)) !!}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="mt-8 pt-6 border-t flex justify-end">
                    <a href="{{ route('pharmacy.view-prescriptions') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div>
             <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if($prescription->status != 'dispensed')
                    <a href="{{ route('pharmacy.show-dispense-form', $prescription->id) }}" class="flex items-center space-x-3 p-3 rounded-lg bg-pharmacist-primary text-white hover:bg-green-700 transition">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                            <i class="fas fa-prescription-bottle-alt"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-medium">Dispense Medication</h3>
                            <p class="text-xs text-green-100">Process prescription</p>
                        </div>
                    </a>
                    @else
                     <div class="p-3 bg-green-50 rounded-lg border border-green-200 text-center">
                        <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
                        <h3 class="font-medium text-green-800">Dispensed</h3>
                        <p class="text-xs text-green-600">This prescription has been processed.</p>
                    </div>
                    @endif
                    
                    <button type="button" class="w-full flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                         <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-medium text-gray-800">Print Label</h3>
                        </div>
                    </button>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
