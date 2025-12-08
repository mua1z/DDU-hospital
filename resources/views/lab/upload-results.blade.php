@extends('lab.layouts.layout')

@section('title', 'Upload Results - DDU Clinics')
@section('page-title', 'Upload Test Results')
@section('page-subtitle', 'Record and finalize laboratory results')

@section('content')
<div class="animate-slade-up">
    <!-- Processing Queue -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tests Ready for Results</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-lab-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Sample ID</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Patient</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Processed By</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $test)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <span class="font-mono font-medium text-gray-800">{{ $test->request_number }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $test->patient->full_name }}</div>
                                    <div class="text-gray-600 text-xs">{{ $test->patient->card_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                {{ $test->test_type }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="text-sm">
                                <div>{{ auth()->user()->name ?? 'N/A' }}</div>
                                <div class="text-gray-600 text-xs">{{ $test->created_at->format('h:i A') }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            @php
                                $statusColors = [
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                ];
                                $statusColor = $statusColors[$test->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ ucfirst(str_replace('_', ' ', $test->status)) }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('lab.upload-results') }}?request_id={{ $test->id }}" class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition text-sm">
                                Enter Results
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">No tests ready for results</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Results Entry Form -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Enter Test Results - <span id="currentTestId">SMP-2024-0621</span></h2>
        
        <form action="{{ route('lab.store-results') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <!-- Test Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Sample ID</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="SMP-2024-0621" readonly>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Patient Name</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="Liya Akiliu" readonly>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Test Type</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="Malaria Smear" readonly>
                </div>
            </div>
            
            <!-- Test Results -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i> Test Results
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-lab-light">
                            <tr>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Parameter</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Result</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Unit</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Reference Range</th>
                                <th class="py-3 px-4 text-left text-gray-700 font-semibold">Flag</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">Malaria Parasite</div>
                                    <div class="text-gray-600 text-sm">Thick Film</div>
                                </td>
                                <td class="py-4 px-4">
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                                        <option value="negative">Negative</option>
                                        <option value="positive" selected>Positive</option>
                                        <option value="scanty">Scanty</option>
                                        <option value="1plus">1+</option>
                                        <option value="2plus">2+</option>
                                        <option value="3plus">3+</option>
                                        <option value="4plus">4+</option>
                                    </select>
                                </td>
                                <td class="py-4 px-4">-</td>
                                <td class="py-4 px-4">Negative</td>
                                <td class="py-4 px-4">
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">ABN</span>
                                </td>
                            </tr>
                            
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">Species</div>
                                </td>
                                <td class="py-4 px-4">
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                                        <option value="">Select species</option>
                                        <option value="pf" selected>Plasmodium falciparum</option>
                                        <option value="pv">Plasmodium vivax</option>
                                        <option value="pm">Plasmodium malariae</option>
                                        <option value="po">Plasmodium ovale</option>
                                    </select>
                                </td>
                                <td class="py-4 px-4">-</td>
                                <td class="py-4 px-4">-</td>
                                <td class="py-4 px-4">
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">ABN</span>
                                </td>
                            </tr>
                            
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">Parasite Density</div>
                                    <div class="text-gray-600 text-sm">Per μL</div>
                                </td>
                                <td class="py-4 px-4">
                                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="2500">
                                </td>
                                <td class="py-4 px-4">/μL</td>
                                <td class="py-4 px-4">0</td>
                                <td class="py-4 px-4">
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">ABN</span>
                                </td>
                            </tr>
                            
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-800">Stage</div>
                                </td>
                                <td class="py-4 px-4">
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                                        <option value="">Select stage</option>
                                        <option value="ring" selected>Ring</option>
                                        <option value="troph">Trophozoite</option>
                                        <option value="schizont">Schizont</option>
                                        <option value="gameto">Gametocyte</option>
                                    </select>
                                </td>
                                <td class="py-4 px-4">-</td>
                                <td class="py-4 px-4">-</td>
                                <td class="py-4 px-4">
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">ABN</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Microscopic Findings</label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="3">Thick film shows 50 parasites per 200 WBCs. Thin film reveals Plasmodium falciparum rings with double chromatin dots. No gametocytes observed. No other blood parasites seen.</textarea>
                </div>
            </div>
            
            <!-- Quality Control -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-clipboard-check mr-2"></i> Quality Control
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">QC Status</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                            <option value="passed" selected>Passed</option>
                            <option value="failed">Failed</option>
                            <option value="warning">Warning</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">QC Reference</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" placeholder="e.g., Lot #, Control ID">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">QC Comments</label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="2" placeholder="Any quality control notes...">Positive control valid. Staining adequate. Microscope calibrated today.</textarea>
                </div>
            </div>
            
            <!-- Finalization -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Finalization
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Result Status *</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" required>
                            <option value="final" selected>Final</option>
                            <option value="preliminary">Preliminary</option>
                            <option value="corrected">Corrected</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Verified By</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="Dr. Sara (Supervisor)" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Interpretation/Notes</label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="3" placeholder="Clinical interpretation, recommendations...">Positive for Plasmodium falciparum malaria. Moderate parasitemia. Recommend immediate antimalarial treatment. Blood film shows typical ring forms.</textarea>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Save Draft
                </button>
                <button type="button" class="px-6 py-3 border border-yellow-600 text-yellow-600 rounded-lg hover:bg-yellow-50 transition">
                    Mark for Review
                </button>
                <button type="submit" class="px-6 py-3 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Publish Results</span>
                </button>
            </div>
        </form>
    </div>
</div>

            <input type="hidden" name="lab_request_id" value="{{ request('request_id') ?? '' }}">