@extends('pharmacy.layouts.layout')

@section('title', 'View Prescriptions - DDU Clinics')
@section('page-title', 'View Prescriptions')
@section('page-subtitle', 'Review and manage prescriptions')

@section('content')
<div class="animate-slade-up">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <form method="GET" action="{{ route('pharmacy.view-prescriptions') }}" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4 flex-wrap">
                <a href="{{ route('pharmacy.view-prescriptions', ['status' => 'all']) }}" 
                   class="px-4 py-2 {{ !request('status') || request('status') === 'all' ? 'bg-pharma-primary text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }} rounded-lg font-medium transition">
                    All ({{ $counts['total'] }})
                </a>
                <a href="{{ route('pharmacy.view-prescriptions', ['status' => 'pending']) }}" 
                   class="px-4 py-2 {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    Pending ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('pharmacy.view-prescriptions', ['status' => 'dispensed']) }}" 
                   class="px-4 py-2 {{ request('status') === 'dispensed' ? 'bg-blue-500 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    Dispensed ({{ $counts['dispensed'] }})
                </a>
                <a href="{{ route('pharmacy.view-prescriptions', ['status' => 'completed']) }}" 
                   class="px-4 py-2 {{ request('status') === 'completed' ? 'bg-green-500 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    Completed ({{ $counts['completed'] }})
                </a>
                <a href="{{ route('pharmacy.view-prescriptions', ['status' => 'cancelled']) }}" 
                   class="px-4 py-2 {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }} rounded-lg transition">
                    Cancelled ({{ $counts['cancelled'] }})
                </a>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by prescription ID or patient..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <input type="date" 
                       name="date" 
                       value="{{ request('date') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
                <button type="submit" class="px-4 py-2 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request('status') || request('search') || request('date'))
                    <a href="{{ route('pharmacy.view-prescriptions') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    <!-- Prescriptions Table -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Prescriptions ({{ $counts['total'] ?? $prescriptions->total() }})</h2>
                <div class="text-gray-600 flex space-x-3">
                    <span class="text-blue-600 font-bold">{{ $counts['pending'] ?? 0 }} Pending</span>
                    <span>|</span>
                    <span class="text-green-600 font-bold">{{ $counts['dispensed'] ?? 0 }} Dispensed</span>
                    <span>|</span>
                    <span class="text-red-600 font-bold">{{ $counts['cancelled'] ?? 0 }} Cancelled</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-pharma-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Prescription ID</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Patient Details</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Medications</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Prescribing Doctor</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Date</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div class="font-mono font-bold text-gray-800">{{ $prescription->prescription_number ?? ('RX'.$prescription->id) }}</div>
                            <div class="text-gray-600 text-xs">{{ $prescription->location ?? 'Main Pharmacy' }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-pharma-light flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-pharma-primary"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $prescription->patient->full_name ?? 'Unknown' }}</div>
                                    <div class="text-gray-600 text-sm">
                                        {{ $prescription->patient->card_number ?? 'N/A' }}
                                        @if($prescription->patient?->date_of_birth)
                                            • {{ \Carbon\Carbon::parse($prescription->patient->date_of_birth)->age }} yrs
                                        @endif
                                        @if($prescription->patient?->gender)
                                            • {{ ucfirst($prescription->patient->gender) }}
                                        @endif
                                    </div>
                                    @if($prescription->diagnosis)
                                    <div class="text-gray-600 text-xs">{{ $prescription->diagnosis }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                @forelse($prescription->items as $med)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-800">{{ $med->medication->name ?? 'Medication' }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-600 text-sm">{{ $med->dosage }}</span>
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $med->quantity }}</span>
                                    </div>
                                </div>
                                @empty
                                <span class="text-gray-500 text-sm">No items</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="font-medium">{{ $prescription->prescribedBy->name ?? 'Unknown' }}</div>
                                <div class="text-gray-600 text-xs">{{ $prescription->prescribedBy->role ?? '' }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="font-medium">{{ $prescription->prescription_date ? \Carbon\Carbon::parse($prescription->prescription_date)->format('M d, Y') : $prescription->created_at->format('M d, Y') }}</div>
                                <div class="text-gray-600">{{ $prescription->created_at->format('h:i A') }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-blue-100 text-blue-800',
                                    'dispensed' => 'bg-green-100 text-green-800',
                                    'partially_dispensed' => 'bg-yellow-100 text-yellow-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$prescription->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $color }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ ucfirst(str_replace('_', ' ', $prescription->status)) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                @if(in_array($prescription->status, ['pending','partially_dispensed']))
                                <a href="{{ route('pharmacy.show-dispense-form', $prescription->id) }}" class="px-4 py-2 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition text-sm">
                                    Dispense
                                </a>
                                @elseif($prescription->status === 'dispensed')
                                <button class="px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm">
                                    <i class="fas fa-check mr-1"></i> Done
                                </button>
                                @endif
                                <button class="p-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">No prescriptions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 border-t">
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection

