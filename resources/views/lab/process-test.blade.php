@extends('lab.layouts.layout')

@section('title', 'Process Test - DDU Clinics')
@section('page-title', 'Process Laboratory Test')
@section('page-subtitle', 'Update test status')

@section('content')
<div class="animate-slide-up">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Test Processing - {{ $request->request_number }}</h2>
            
            <form action="{{ route('lab.update-request-status', $request->id) }}" method="POST" class="space-y-6">
                @csrf
                <!-- Patient Information -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-user-injured mr-2"></i> Patient Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Patient Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $request->patient->full_name }}" readonly>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Card No.</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $request->patient->card_number }}" readonly>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Age & Gender</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $request->patient->date_of_birth ? \Carbon\Carbon::parse($request->patient->date_of_birth)->age . ' years' : 'N/A' }}, {{ ucfirst($request->patient->gender ?? 'N/A') }}" readonly>
                        </div>
                    </div>
                </div>
                
                <!-- Test Details -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-flask mr-2"></i> Test Details
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Test Type</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $request->test_type }}" readonly>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Priority</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg {{ $request->priority == 'urgent' || $request->priority == 'stat' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700' }} font-medium" value="{{ strtoupper($request->priority) }}" readonly>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Clinical Notes</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" rows="2" readonly>{{ $request->clinical_notes ?? 'No clinical notes provided' }}</textarea>
                    </div>
                </div>
                
                <!-- Status Update -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-tasks mr-2"></i> Update Status
                    </h3>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Status *</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" required>
                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $request->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('lab.pending-requests') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <a href="{{ route('lab.upload-results') }}?request_id={{ $request->id }}" class="px-6 py-3 border border-lab-primary text-lab-primary rounded-lg hover:bg-purple-50 transition">
                        Go to Upload Results
                    </a>
                    <button type="submit" class="px-6 py-3 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Update Status</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection