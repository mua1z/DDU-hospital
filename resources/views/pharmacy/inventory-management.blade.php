@extends('pharmacy.layouts.layout')

@section('title', 'Inventory Management - DDU Clinics')
@section('page-title', 'Inventory Management')
@section('page-subtitle', 'Manage pharmacy stock')

@section('content')
<div class="animate-slide-up" x-data="{ showEditModal: false, editItem: { id: '', medication_id: '', quantity: '', minimum_stock_level: '', expiry_date: '', batch_number: '', unit_price: '', supplier: '', received_date: '', notes: '' } }">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Inventory Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Add Inventory Item</h2>
                
                <form action="{{ route('pharmacy.store-inventory') }}" method="POST" class="space-y-6">
                    @csrf
                        <div class="md:col-span-2" x-data="{ isNewMedication: false }">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Medication *</label>
                            
                            <!-- Toggle between existing and new medication -->
                            <div class="flex items-center mb-3 space-x-4">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="medication_mode" value="existing" x-model="isNewMedication" :value="false" checked class="form-radio h-4 w-4 text-pharma-primary">
                                    <span class="ml-2 text-sm text-gray-700">Select Existing</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="medication_mode" value="new" x-model="isNewMedication" :value="true" class="form-radio h-4 w-4 text-green-600">
                                    <span class="ml-2 text-sm text-gray-700">Add New Medication</span>
                                </label>
                            </div>
                            
                            <!-- Existing Medication Dropdown -->
                            <div x-show="!isNewMedication">
                                <select name="medication_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary" :required="!isNewMedication">
                                    <option value="">Select Medication</option>
                                    @foreach($medications as $medication)
                                    <option value="{{ $medication->id }}">{{ $medication->name }} {{ $medication->strength ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('medication_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- New Medication Fields -->
                            <div x-show="isNewMedication" x-transition class="space-y-3 p-4 bg-green-50 rounded-lg border border-green-200">
                                <p class="text-green-700 text-xs font-medium mb-2"><i class="fas fa-plus-circle mr-1"></i>Adding New Medication to System</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-gray-700 text-xs font-medium mb-1">Medication Name *</label>
                                        <input type="text" name="new_medication_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm" placeholder="e.g., Amoxicillin" :required="isNewMedication">
                                        @error('new_medication_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-medium mb-1">Generic Name</label>
                                        <input type="text" name="new_generic_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm" placeholder="e.g., Amoxicillin">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-medium mb-1">Dosage Form</label>
                                        <select name="new_dosage_form" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                            <option value="">Select Form</option>
                                            <option value="Tablet">Tablet</option>
                                            <option value="Capsule">Capsule</option>
                                            <option value="Syrup">Syrup</option>
                                            <option value="Injection">Injection</option>
                                            <option value="Cream">Cream</option>
                                            <option value="Ointment">Ointment</option>
                                            <option value="Drops">Drops</option>
                                            <option value="Inhaler">Inhaler</option>
                                            <option value="Suppository">Suppository</option>
                                            <option value="Powder">Powder</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-medium mb-1">Strength</label>
                                        <input type="text" name="new_strength" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm" placeholder="e.g., 500mg">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-medium mb-1">Category</label>
                                        <select name="new_category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                            <option value="">Select Category</option>
                                            <option value="Antibiotics">Antibiotics</option>
                                            <option value="Analgesics">Analgesics (Pain Relief)</option>
                                            <option value="Antipyretics">Antipyretics (Fever)</option>
                                            <option value="Antidiabetics">Antidiabetics</option>
                                            <option value="Antihypertensives">Antihypertensives</option>
                                            <option value="Antihistamines">Antihistamines</option>
                                            <option value="Vitamins">Vitamins & Supplements</option>
                                            <option value="Gastrointestinal">Gastrointestinal</option>
                                            <option value="Respiratory">Respiratory</option>
                                            <option value="Dermatological">Dermatological</option>
                                            <option value="Cardiovascular">Cardiovascular</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center pt-5">
                                        <input type="checkbox" name="new_requires_prescription" id="new_requires_prescription" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <label for="new_requires_prescription" class="ml-2 block text-xs text-gray-700">Requires Prescription</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
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
                            <td class="py-4 px-4 flex space-x-2">
                                <button @click="editItem = {
                                    id: {{ $item->id }},
                                    medication_id: {{ $item->medication_id }},
                                    quantity: {{ $item->quantity }},
                                    minimum_stock_level: {{ $item->minimum_stock_level }},
                                    expiry_date: '{{ $item->expiry_date ? $item->expiry_date->format('Y-m-d') : '' }}',
                                    batch_number: '{{ $item->batch_number ?? '' }}',
                                    unit_price: '{{ $item->unit_price ?? '' }}',
                                    supplier: '{{ $item->supplier ?? '' }}',
                                    received_date: '{{ $item->received_date ? $item->received_date->format('Y-m-d') : '' }}',
                                    notes: '{{ $item->notes ?? '' }}'
                                }; showEditModal = true" class="text-blue-600 hover:text-blue-800 p-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('pharmacy.destroy-inventory', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');" class="inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showEditModal = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="'{{ url('pharmacy/inventory-management') }}/' + editItem.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Edit Inventory Item</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Medication</label>
                                <select name="medication_id" x-model="editItem.medication_id" class="w-full border-gray-300 rounded-lg p-2 focus:ring-pharma-primary focus:border-pharma-primary">
                                    @foreach($medications as $med)
                                    <option value="{{ $med->id }}">{{ $med->name }} {{ $med->strength ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Quantity</label>
                                    <input type="number" name="quantity" x-model="editItem.quantity" class="w-full border-gray-300 rounded-lg p-2" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Min Level</label>
                                    <input type="number" name="minimum_stock_level" x-model="editItem.minimum_stock_level" class="w-full border-gray-300 rounded-lg p-2" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Expiry Date</label>
                                    <input type="date" name="expiry_date" x-model="editItem.expiry_date" class="w-full border-gray-300 rounded-lg p-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Batch Number</label>
                                    <input type="text" name="batch_number" x-model="editItem.batch_number" class="w-full border-gray-300 rounded-lg p-2">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Unit Price</label>
                                    <input type="number" step="0.01" name="unit_price" x-model="editItem.unit_price" class="w-full border-gray-300 rounded-lg p-2">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Supplier</label>
                                    <input type="text" name="supplier" x-model="editItem.supplier" class="w-full border-gray-300 rounded-lg p-2">
                                </div>
                            </div>
                             <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Notes</label>
                                <textarea name="notes" x-model="editItem.notes" class="w-full border-gray-300 rounded-lg p-2" rows="2"></textarea>
                             </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-pharma-primary text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Update Item
                        </button>
                        <button type="button" @click="showEditModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

