@extends('lab.layouts.layout')

@section('title', 'Process Test - DDU Clinics')
@section('page-title', 'Process Laboratory Test')
@section('page-subtitle', 'Perform and record test procedures')

@section('content')
<div class="animate-slade-up">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Test Processing Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Test Processing - {{ $request->request_number }}</h2>
                
                <form action="{{ route('lab.update-request-status', $request->id) }}" method="POST" class="space-y-8">
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
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg {{ $request->priority == 'urgent' || $request->priority == 'critical' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700' }} font-medium" value="{{ strtoupper($request->priority) }}" readonly>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Clinical Notes</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" rows="2" readonly>{{ $request->clinical_notes ?? 'No clinical notes provided' }}</textarea>
                        </div>
                    </div>
                    
                    <!-- Sample Collection -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-tint mr-2"></i> Sample Collection
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Sample Type *</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" required>
                                    <option value="">Select sample type</option>
                                    <option value="blood" selected>Blood</option>
                                    <option value="urine">Urine</option>
                                    <option value="stool">Stool</option>
                                    <option value="sputum">Sputum</option>
                                    <option value="swab">Swab</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Sample ID *</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="SMP-2024-0621" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Collection Time *</label>
                                <input type="datetime-local" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Collector *</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="Nurse Sarah" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Sample Condition</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                                    <option value="good" selected>Good</option>
                                    <option value="hemolyzed">Hemolyzed</option>
                                    <option value="clotted">Clotted</option>
                                    <option value="insufficient">Insufficient</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Test Procedure -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-microscope mr-2"></i> Test Procedure
                        </h3>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Method Used *</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" required>
                                <option value="">Select method</option>
                                <option value="giemsa" selected>Giemsa Stain Microscopy</option>
                                <option value="rapid">Rapid Diagnostic Test</option>
                                <option value="pcr">PCR</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Procedure Notes</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="3" placeholder="Describe the procedure steps, any observations...">Thick and thin blood films prepared. Giemsa stain applied. Microscopic examination at 100x oil immersion.</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Equipment Used</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="Microscope #3, Centrifuge #1" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Reagents Used</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="Giemsa Stain, Methanol" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preliminary Results -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-clipboard-check mr-2"></i> Preliminary Findings
                        </h3>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Microscopic Findings</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="4" placeholder="Describe microscopic findings...">Thick film: 50 parasites per 200 WBCs. Thin film: Plasmodium falciparum rings detected. No gametocytes observed.</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Parasite Density</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" placeholder="e.g., 2500/μL">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Species</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                                    <option value="">Select species</option>
                                    <option value="pf">P. falciparum</option>
                                    <option value="pv">P. vivax</option>
                                    <option value="pm">P. malariae</option>
                                    <option value="po">P. ovale</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Stage</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                                    <option value="">Select stage</option>
                                    <option value="ring">Ring</option>
                                    <option value="troph">Trophozoite</option>
                                    <option value="schizont">Schizont</option>
                                    <option value="gameto">Gametocyte</option>
                                </select>
                            </div>
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
                        <a href="{{ route('lab.upload-results') }}" class="px-6 py-3 border border-lab-primary text-lab-primary rounded-lg hover:bg-purple-50 transition">
                            Skip to Results
                        </a>
                        <button type="submit" class="px-6 py-3 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Update Status</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar: Test Instructions & QC -->
        <div>
            <!-- Test Instructions -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Test Instructions</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="font-medium text-gray-800 mb-2">Malaria Smear Procedure</h3>
                        <ol class="list-decimal pl-5 text-sm text-gray-600 space-y-1">
                            <li>Prepare thick and thin blood films</li>
                            <li>Fix thin film with methanol</li>
                            <li>Stain with Giemsa (3%) for 30 min</li>
                            <li>Examine under 100x oil immersion</li>
                            <li>Count parasites per 200 WBCs</li>
                        </ol>
                    </div>
                    
                    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <h3 class="font-medium text-gray-800 mb-2">Safety Precautions</h3>
                        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                            <li>Wear gloves and lab coat</li>
                            <li>Use biological safety cabinet</li>
                            <li>Properly dispose of sharps</li>
                            <li>Disinfect work area after</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                        <h3 class="font-medium text-gray-800 mb-2">Quality Control</h3>
                        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                            <li>Run positive control daily</li>
                            <li>Check stain quality</li>
                            <li>Verify microscope calibration</li>
                            <li>Document QC results</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">View SOP</h3>
                            <p class="text-gray-600 text-sm">Standard procedure</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('lab.quality-control') }}" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">QC Records</h3>
                            <p class="text-gray-600 text-sm">Quality control</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('lab.inventory') }}" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i class="fas fa-boxes text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Check Supplies</h3>
                            <p class="text-gray-600 text-sm">Reagents & consumables</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('lab.upload-results') }}" class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-upload text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Upload Results</h3>
                            <p class="text-gray-600 text-sm">Finalize test</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection