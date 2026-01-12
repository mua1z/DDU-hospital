@extends('lab.layouts.layout')

@section('title', 'Upload Results - DDU Clinics')
@section('page-title', 'Upload Test Results')
@section('page-subtitle', 'Record and finalize laboratory results')

@section('content')
<div class="animate-slide-up">
    <!-- Notifications -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
        <p class="font-bold">Success</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
        <p class="font-bold">Error</p>
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
        <p class="font-bold">Whoops! Something went wrong.</p>
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Processing Queue -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tests Ready for Results</h2>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-lab-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Request ID</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Patient</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test Type</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test Date</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
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
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-gray-600">{{ $test->patient->card_number }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-block bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded">
                                {{ $test->test_type }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="text-sm">
                                {{ $test->created_at->format('M d, Y') }}
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
                            <div class="flex space-x-2">
                                <a href="{{ route('lab.upload-results') }}?request_id={{ $test->id }}"
                                   class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition text-sm flex items-center space-x-1">
                                    <i class="fas fa-upload text-xs"></i>
                                    <span>Upload Results</span>
                                </a>
                                <a href="{{ route('lab.view-result-details', $test->id) }}"
                                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm flex items-center space-x-1">
                                    <i class="fas fa-eye text-xs"></i>
                                    <span>View</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            <i class="fas fa-clipboard-list text-3xl text-gray-300 mb-2"></i>
                            <p>No tests ready for results</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 pt-4 border-t">
            {{ $requests->links() }}
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
                    <label class="block text-gray-700 text-sm font-medium mb-2">Request ID</label>
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
                    <label class="block text-gray-700 text-sm font-medium mb-2">Test Outcome</label>
                    <select name="results" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                        <option value="">Select Outcome</option>
                        <option value="Positive" @selected(old('results') === 'Positive')>Positive</option>
                        <option value="Negative" @selected(old('results') === 'Negative')>Negative</option>
                        <option value="Indeterminate" @selected(old('results') === 'Indeterminate')>Indeterminate</option>
                    </select>
                    <!-- Hidden input for "Other" if needed in future, staying simple for now as requested -->

                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Test Values</label>
                    <textarea name="test_values" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary @error('test_values') border-red-500 @enderror" rows="4" placeholder="Enter test values details...">{{ old('test_values') }}</textarea>
                    @error('test_values')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
                    <input type="file" name="result_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary @error('result_file') border-red-500 @enderror">
                    @error('result_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
                    <a href="{{ route('lab.upload-results') }}" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
        @else
        <div class="text-center py-12 text-gray-600">
            <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium mb-2">No Test Selected</h3>
            <p class="max-w-md mx-auto">Select a test from the list above to enter results, or wait for lab requests to become available.</p>
        </div>
        @endif
    </div>
</div>
@endsection
