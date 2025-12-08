@extends('pharmacy.layouts.layout')

@section('title', 'Inventory Management - DDU Clinics')
@section('page-title', 'Inventory Management')
@section('page-subtitle', 'Manage pharmacy stock')

@section('content')
<div class="animate-slide-up">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Inventory Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Add Inventory Item</h2>
                
                <form action="{{ route('pharmacy.store-inventory') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Medication *</label>
                            <select name="medication_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" required>
                                <option value="">Select Medication</option>
                                @foreach($medications as $medication)
                                <option value="{{ $medication->id }}">{{ $medication->name }} {{ $medication->strength ?? '' }}</option>
                                @endforeach
                            </select>
                            @error('medication_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Batch Number</label>
                            <input type="text" name="batch_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" placeholder="BATCH-XXX-YYYY" value="{{ old('batch_number') }}">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Quantity *</label>
                            <input type="number" name="quantity" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" min="1" value="{{ old('quantity') }}" required>
                            @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Minimum Stock Level *</label>
                            <input type="number" name="minimum_stock_level" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" min="0" value="{{ old('minimum_stock_level', 10) }}" required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Expiry Date</label>
                            <input type="date" name="expiry_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" value="{{ old('expiry_date') }}">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Unit Price</label>
                            <input type="number" name="unit_price" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" value="{{ old('unit_price') }}">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Supplier</label>
                            <input type="text" name="supplier" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" value="{{ old('supplier') }}">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Received Date</label>
                            <input type="date" name="received_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" value="{{ old('received_date', now()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Notes</label>
                        <textarea name="notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-4 border-t">
                        <button type="reset" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Clear
                        </button>
                        <button type="submit" class="px-6 py-3 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition">
                            Add to Inventory
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div>
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Inventory Stats</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Total Items</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $inventory->total() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Low Stock Items</p>
                        <p class="text-2xl font-bold text-red-600">{{ $inventory->where('quantity', '<=', 'minimum_stock_level')->count() }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Expiring Soon</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $inventory->whereBetween('expiry_date', [now(), now()->addDays(30)])->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inventory Table -->
    <div class="mt-8 animate-slide-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Current Inventory</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-pharma-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Medication</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Batch No.</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Quantity</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Min. Level</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Expiry Date</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventory as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="font-medium">{{ $item->medication->name }}</div>
                                <div class="text-gray-600 text-xs">{{ $item->medication->strength ?? '' }} • {{ $item->medication->dosage_form ?? '' }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-mono text-sm">{{ $item->batch_number ?? 'N/A' }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="font-bold {{ $item->quantity <= $item->minimum_stock_level ? 'text-red-600' : 'text-gray-800' }}">{{ $item->quantity }}</span>
                            </td>
                            <td class="py-4 px-4">{{ $item->minimum_stock_level }}</td>
                            <td class="py-4 px-4">
                                @if($item->expiry_date)
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $item->expiry_date->format('Y-m-d') }}</div>
                                        @if($item->expiry_date->isPast())
                                            <span class="text-red-600 text-xs">Expired</span>
                                        @elseif($item->expiry_date->diffInDays(now()) <= 30)
                                            <span class="text-yellow-600 text-xs">Expiring Soon</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($item->quantity <= $item->minimum_stock_level)
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">Low Stock</span>
                                @else
                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">In Stock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No inventory items found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $inventory->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

