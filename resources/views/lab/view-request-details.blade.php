@extends('lab.layouts.layout')

@section('title', 'Request Details - DDU Clinics')
@section('page-title', 'Lab Request Details')
@section('page-subtitle', 'View test request information')

@section('content')
<div class="animate-slade-up">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Request Details -->
        <div class="md:col-span-3 lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Request #{{ $request->request_number }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($request->priority == 'urgent' || $request->priority == 'critical') bg-red-100 text-red-800
                        @elseif($request->priority == 'stat') bg-purple-100 text-purple-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($request->priority) }}
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
                            <div class="font-medium text-gray-900">{{ $request->patient->full_name }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Card No.</label>
                            <div class="font-medium text-gray-900">{{ $request->patient->card_number }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Age & Gender</label>
                            <div class="font-medium text-gray-900">
                                {{ $request->patient->date_of_birth ? \Carbon\Carbon::parse($request->patient->date_of_birth)->age . ' years' : 'N/A' }}, 
                                {{ ucfirst($request->patient->gender ?? 'N/A') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Test Details -->
                <div class="space-y-4 mb-8">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-flask mr-2"></i> Test Details
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Test Type</label>
                            <div class="font-medium text-gray-900">{{ $request->test_type }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Requested By</label>
                            <div class="font-medium text-gray-900">Dr. {{ $request->requestedBy->name ?? 'Unknown' }}</div>
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Clinical Notes</label>
                             <div class="bg-gray-50 p-3 rounded-lg text-gray-700 text-sm">
                                 {{ $request->clinical_notes ?? 'No clinical notes provided.' }}
                             </div>
                        </div>
                    </div>
                </div>
                
                <!-- Timeline/Status -->
                <div class="space-y-4">
                     <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-clock mr-2"></i> Timeline
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Requested On</label>
                            <div class="font-medium text-gray-900">{{ $request->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-500 text-xs font-medium uppercase mb-1">Current Status</label>
                            <div class="font-medium capitalize text-gray-900">{{ str_replace('_', ' ', $request->status) }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t flex justify-end">
                    <a href="{{ route('lab.pending-requests') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
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
                    <a href="{{ route('lab.process-test-id', $request->id) }}" class="flex items-center space-x-3 p-3 rounded-lg bg-lab-primary text-white hover:bg-purple-700 transition">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-medium">Process Test</h3>
                            <p class="text-xs text-purple-100">Start procedure</p>
                        </div>
                    </a>
                    
                    <button type="button" class="w-full flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                         <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-medium text-gray-800">Print Request</h3>
                        </div>
                    </button>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
