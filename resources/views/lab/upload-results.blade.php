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
        @if($selectedRequest)
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Enter Test Results - <span class="font-mono">{{ $selectedRequest->request_number }}</span>
        </h2>
        
        <form action="{{ route('lab.store-results') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <input type="hidden" name="lab_request_id" value="{{ $selectedRequest->id }}">

            <!-- Test Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Sample / Request ID</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $selectedRequest->request_number }}" readonly>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Patient Name</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $selectedRequest->patient->full_name }}" readonly>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Test Type</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $selectedRequest->test_type }}" readonly>
                </div>
            </div>
            
            <!-- Results -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Results (summary)</label>
                    <textarea name="results" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="4" placeholder="Key findings and quantitative values">{{ old('results') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Test Values (JSON, optional)</label>
                    <textarea name="test_values" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="4" placeholder='[{"name":"WBC","value":"5.4","unit":"10^3/uL"}]'>{{ old('test_values') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Leave blank if not applicable</p>
                </div>
            </div>
            
            <!-- Interpretation -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Findings</label>
                    <textarea name="findings" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="4" placeholder="Summarize key observations">{{ old('findings') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Recommendations</label>
                    <textarea name="recommendations" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" rows="4" placeholder="Follow-up tests, treatments, or monitoring suggestions">{{ old('recommendations') }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Result Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                        @foreach(['pending','completed','critical'] as $status)
                            <option value="{{ $status }}" @selected(old('status', 'completed') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Test Date</label>
                    <input type="date" name="test_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary" value="{{ old('test_date', now()->toDateString()) }}">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Attach Result File (PDF/Image)</label>
                    <input type="file" name="result_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                    <p class="text-xs text-gray-500 mt-1">Max 10MB</p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-gray-600 text-sm">
                    Fill in results for <span class="font-medium">{{ $selectedRequest->patient->full_name }}</span>. The lab request will be marked completed after submission.
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" class="px-5 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition flex items-center space-x-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit Results</span>
                    </button>
                </div>
            </div>
        </form>
        @else
        <div class="text-center py-12 text-gray-600">
            No lab requests available for result entry. Once a doctor submits a lab request, it will appear here.
        </div>
        @endif
    </div>
</div>

            <input type="hidden" name="lab_request_id" value="{{ request('request_id') ?? '' }}">