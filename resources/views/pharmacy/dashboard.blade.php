@extends('pharmacy.layouts.layout')

@section('title', 'Pharmacy Dashboard - DDU Clinics')
@section('page-title', 'Welcome, Pharmacist')
@section('page-subtitle', 'Pharmacy Dashboard')

@section('content')
<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slide-up">
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Pending Prescriptions</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['pending_prescriptions'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-prescription text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('pharmacy.view-prescriptions') }}" class="text-blue-600 text-sm font-medium hover:underline">View All →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Today's Dispensed</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['today_dispensed'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-pills text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('pharmacy.dispense-medications') }}" class="text-green-600 text-sm font-medium hover:underline">Dispense Now →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Low Stock Items</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['low_stock_items'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('pharmacy.inventory-management') }}" class="text-red-600 text-sm font-medium hover:underline">Check Inventory →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Expiring Soon</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['expiring_soon'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-calendar-times text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('pharmacy.check-expiry') }}" class="text-yellow-600 text-sm font-medium hover:underline">Check Expiry →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Prescriptions -->
    <div class="animate-slide-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Recent Prescriptions</h2>
                    <a href="{{ route('pharmacy.view-prescriptions') }}" class="text-pharma-primary hover:underline font-medium">View All</a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-pharma-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Prescription ID</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Student</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Drugs Prescribed</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPrescriptions as $prescription)
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
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($prescription->items->take(2) as $item)
                                    <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">{{ $item->medication->name }}</span>
                                    @endforeach
                                    @if($prescription->items->count() > 2)
                                    <span class="bg-gray-100 text-gray-800 py-1 px-2 rounded text-xs">+{{ $prescription->items->count() - 2 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('pharmacy.show-dispense-form', $prescription->id) }}" class="px-4 py-2 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition text-sm">
                                    Dispense
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No pending prescriptions
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Alerts -->
    <div class="animate-slide-up" style="animation-delay: 0.2s">
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Low Stock Alerts</h2>
                    <a href="{{ route('pharmacy.inventory-management') }}" class="text-pharma-primary hover:underline font-medium">Manage Inventory</a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-pharma-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Drug</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Quantity Left</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Expiry Date</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockItems as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-pills text-red-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $item->medication->name }}</div>
                                        <div class="text-gray-600 text-xs">{{ $item->medication->strength }} • {{ $item->medication->dosage_form }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold {{ $item->quantity <= 5 ? 'text-red-600' : 'text-yellow-600' }}">{{ $item->quantity }}</div>
                                    <div class="text-gray-600 text-xs">Units</div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @if($item->expiry_date)
                                <div class="text-sm">
                                    <div class="font-medium">{{ $item->expiry_date->format('Y-m-d') }}</div>
                                    <div class="text-gray-600">{{ $item->expiry_date->diffForHumans() }}</div>
                                </div>
                                @else
                                <div class="text-sm text-gray-500">N/A</div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($item->quantity <= 5)
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">Critical</span>
                                @else
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">Low</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('pharmacy.inventory-management') }}" class="px-4 py-2 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition text-sm">
                                    Order
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No low stock items
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 animate-slide-up" style="animation-delay: 0.3s">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <a href="{{ route('pharmacy.view-prescriptions') }}" class="dashboard-card bg-white border border-blue-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-blue-300 hover:bg-blue-50 transition">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                    <i class="fas fa-prescription text-blue-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">View Prescriptions</h3>
                <p class="text-gray-600 text-sm">Check pending orders</p>
            </a>
            
            <a href="{{ route('pharmacy.dispense-medications') }}" class="dashboard-card bg-white border border-green-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-green-300 hover:bg-green-50 transition">
                <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                    <i class="fas fa-pills text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Dispense Medications</h3>
                <p class="text-gray-600 text-sm">Process prescriptions</p>
            </a>
            
            <a href="{{ route('pharmacy.inventory-management') }}" class="dashboard-card bg-white border border-red-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-red-300 hover:bg-red-50 transition">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                    <i class="fas fa-boxes text-red-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Inventory</h3>
                <p class="text-gray-600 text-sm">Manage stock</p>
            </a>
            
            <a href="{{ route('pharmacy.check-expiry') }}" class="dashboard-card bg-white border border-yellow-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-yellow-300 hover:bg-yellow-50 transition">
                <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Check Expiry</h3>
                <p class="text-gray-600 text-sm">Monitor expiry dates</p>
            </a>
            
            <a href="{{ route('pharmacy.generate-reports') }}" class="dashboard-card bg-white border border-purple-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-purple-300 hover:bg-purple-50 transition">
                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                    <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Generate Reports</h3>
                <p class="text-gray-600 text-sm">Create pharmacy reports</p>
            </a>
        </div>
    </div>
</div>

<!-- Pharmacy Statistics -->
<div class="mt-8 animate-slide-up" style="animation-delay: 0.4s">
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Today's Pharmacy Statistics</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['today_dispensed'] }}</div>
                    <div class="text-gray-700 font-medium">Prescriptions</div>
                    <div class="text-gray-600 text-sm">Processed Today</div>
                </div>
                
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['medications_dispensed'] }}</div>
                    <div class="text-gray-700 font-medium">Medications</div>
                    <div class="text-gray-600 text-sm">Dispensed Today</div>
                </div>
                
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <div class="text-3xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</div>
                    <div class="text-gray-700 font-medium">Out of Stock</div>
                    <div class="text-gray-600 text-sm">Items to Order</div>
                </div>
                
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-3xl font-bold text-yellow-600">{{ $stats['expiring_soon'] }}</div>
                    <div class="text-gray-700 font-medium">Expiring Soon</div>
                    <div class="text-gray-600 text-sm">Within 30 days</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection