@extends('pharmacy.layouts.layout')

@section('title', 'Dispense Medications - DDU Clinics')
@section('page-title', 'Dispense Medications')
@section('page-subtitle', 'Process and dispense prescriptions')

@section('content')
@if(isset($prescription))
    <!-- Dispense Form for Specific Prescription -->
    <div class="animate-slide-up">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Dispense Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Dispense Medication - {{ $prescription->prescription_number }}</h2>
                    
                    <form action="{{ route('pharmacy.update-dispense-status', $prescription->id) }}" method="POST" class="space-y-8">
                        @csrf
                        <!-- Prescription Information -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                                <i class="fas fa-prescription mr-2"></i> Prescription Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Prescription ID</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $prescription->prescription_number }}" readonly>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Patient Name</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $prescription->patient->full_name }}" readonly>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Card No.</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $prescription->patient->card_number }}" readonly>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Diagnosis</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $prescription->diagnosis ?? 'N/A' }}" readonly>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Prescribing Doctor</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $prescription->prescribedBy->name ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Medications to Dispense -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                                <i class="fas fa-pills mr-2"></i> Medications to Dispense
                            </h3>
                            
                            <div class="space-y-4">
                                @foreach($medications as $index => $med)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <input type="hidden" name="items[{{ $index }}][item_id]" value="{{ $med['id'] }}">
                                    
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full {{ $med['bgColor'] }} flex items-center justify-center mr-3">
                                                <i class="fas fa-pills {{ $med['textColor'] }}"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-800">{{ $med['name'] }}</h4>
                                                <div class="text-gray-600 text-sm">{{ $med['type'] }} • {{ $med['strength'] }}</div>
                                                <div class="text-gray-500 text-xs mt-1">{{ $med['dosage'] }} - {{ $med['frequency'] }}</div>
                                            </div>
                                        </div>
                                        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm font-medium">
                                            {{ $med['available'] }} in stock
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-gray-700 text-sm font-medium mb-2">Prescribed</label>
                                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" value="{{ $med['prescribed'] }}" readonly>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-gray-700 text-sm font-medium mb-2">Available Stock</label>
                                            <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" value="{{ $med['available'] }}" readonly>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-gray-700 text-sm font-medium mb-2">Dispense Quantity *</label>
                                            <input type="number" name="items[{{ $index }}][quantity]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" min="0" max="{{ $med['available'] }}" value="{{ $med['dispense'] }}" required>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-gray-700 text-sm font-medium mb-2">Batch No.</label>
                                            <select name="items[{{ $index }}][batch_id]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
                                                <option value="">Select Batch</option>
                                                @forelse($med['batches'] as $batch)
                                                <option value="{{ $batch['id'] }}">{{ $batch['number'] }} (Exp: {{ $batch['expiry'] }}) - Qty: {{ $batch['quantity'] }}</option>
                                                @empty
                                                <option value="" disabled>No batches available</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    
                                    @if($med['lowStock'])
                                    <div class="mt-3 p-2 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-center">
                                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                            <div class="text-sm text-red-700">Low stock! Only {{ $med['available'] }} remaining.</div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="mt-3">
                                        <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                                        <select name="items[{{ $index }}][status]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" required>
                                            <option value="dispensed" {{ $med['available'] >= $med['dispense'] ? 'selected' : '' }}>Dispensed</option>
                                            <option value="out_of_stock" {{ $med['available'] < $med['dispense'] ? 'selected' : '' }}>Out of Stock</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Dispensing Details -->
                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                                <i class="fas fa-clipboard-check mr-2"></i> Dispensing Details
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Dispensing Pharmacist *</label>
                                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" value="{{ auth()->user()->name }}" required readonly>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Dispensing Date *</label>
                                    <input type="datetime-local" name="dispensing_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Patient Instructions</label>
                                <textarea name="patient_instructions" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" rows="3" placeholder="Additional instructions for the patient...">{{ $prescription->notes ?? '' }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Pharmacy Notes</label>
                                <textarea name="pharmacy_notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" rows="2" placeholder="Internal notes..."></textarea>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pt-6 border-t">
                            <a href="{{ route('pharmacy.dispense-medications') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition flex items-center space-x-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Complete Dispensing</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar: Patient Info & Stock Check -->
            <div>
                <!-- Patient Information -->
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Patient Information</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16 rounded-full bg-pink-100 flex items-center justify-center">
                                <i class="fas fa-user text-pink-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $prescription->patient->full_name }}</h3>
                                <p class="text-gray-600">{{ $prescription->patient->card_number }} 
                                    @if($prescription->patient->date_of_birth)
                                        • {{ \Carbon\Carbon::parse($prescription->patient->date_of_birth)->age }} years
                                    @endif
                                    @if($prescription->patient->gender)
                                        • {{ ucfirst($prescription->patient->gender) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        @if(!empty($allergies))
                        <div class="pt-4 border-t">
                            <h4 class="font-medium text-gray-800 mb-2">Known Allergies</h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach($allergies as $allergy)
                                <span class="bg-red-100 text-red-800 py-1 px-2 rounded text-xs">{{ trim($allergy) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if($prescription->patient->phone)
                        <div class="pt-4 border-t">
                            <h4 class="font-medium text-gray-800 mb-2">Contact</h4>
                            <div class="text-sm text-gray-600">{{ $prescription->patient->phone }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Quick Stock Check -->
                @if(!empty($stockCheck))
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Stock Check</h2>
                    
                    <div class="space-y-3">
                        @foreach($stockCheck as $item)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full {{ $item['bgColor'] }} flex items-center justify-center mr-3">
                                    <i class="fas fa-pills {{ $item['textColor'] }}"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $item['name'] }}</div>
                                    <div class="text-gray-600 text-xs">{{ $item['type'] }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold {{ $item['stockClass'] }}">{{ $item['stock'] }}</div>
                                <div class="text-gray-600 text-xs">in stock</div>
                            </div>
                        </div>
                        @endforeach
                        
                        <a href="{{ route('pharmacy.inventory-management') }}" class="block text-center text-pharma-primary hover:underline pt-3 border-t">
                            View Full Inventory →
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@else
    <!-- List of Prescriptions to Dispense -->
    <div class="animate-slide-up">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Pending Prescriptions</h2>
            
            @if($prescriptions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-pharma-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Prescription ID</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Patient</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Doctor</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Items</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescriptions as $prescription)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <span class="font-mono font-bold text-gray-800">{{ $prescription->prescription_number }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <span>{{ $prescription->patient->full_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $prescription->patient->card_number }}</span>
                            </td>
                            <td class="py-4 px-4">{{ $prescription->prescribedBy->name ?? 'N/A' }}</td>
                            <td class="py-4 px-4">{{ $prescription->prescription_date->format('M d, Y') }}</td>
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($prescription->items as $item)
                                    <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">{{ $item->medication->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $prescription->status)) }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('pharmacy.view-prescription-details', $prescription->id) }}" class="p-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pharmacy.show-dispense-form', $prescription->id) }}" class="px-4 py-2 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition text-sm">
                                        Dispense
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-prescription text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-600 text-lg">No pending prescriptions to dispense</p>
            </div>
            @endif
        </div>
    </div>
@endif
@endsection
