@extends('patient.layouts.layout')

@section('title', 'Lab Result Details - DDU Clinics')
@section('page-title', 'Lab Result Details')
@section('page-subtitle', 'Detailed laboratory test results')

@section('content')
<div class="animate-slide-up">
    <!-- Action Buttons -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('patient.lab-results') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Results</span>
        </a>
        <div class="flex space-x-3">
            @if($result->result_file)
            <a href="{{ Storage::disk('public')->url($result->result_file) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                <i class="fas fa-file-download"></i>
                <span>Download File</span>
            </a>
            @endif
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                <i class="fas fa-print"></i>
                <span>Print</span>
            </button>
        </div>
    </div>

    <!-- Test Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Test Request Info -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-flask text-blue-600 mr-2"></i>
                Test Information
            </h3>
            <div class="space-y-3">
                <div>
                    <div class="text-xs text-gray-500 uppercase">Request Number</div>
                    <div class="font-mono font-semibold text-gray-800">{{ $result->labRequest->request_number }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Test Type</div>
                    <div class="font-medium text-gray-700">{{ $result->labRequest->test_type }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Requested By</div>
                    <div class="font-medium text-gray-700">
                        {{ $result->labRequest->requestedBy->name ?? 'N/A' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Request Date</div>
                    <div class="font-medium text-gray-700">
                        {{ $result->labRequest->requested_date ? \Carbon\Carbon::parse($result->labRequest->requested_date)->format('M d, Y') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Info -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clipboard-check text-green-600 mr-2"></i>
                Result Information
            </h3>
            <div class="space-y-3">
                <div>
                    <div class="text-xs text-gray-500 uppercase">Test Date</div>
                    <div class="font-medium text-gray-700">
                        {{ $result->test_date ? \Carbon\Carbon::parse($result->test_date)->format('M d, Y') : 'N/A' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Result Date</div>
                    <div class="font-medium text-gray-700">
                        {{ $result->result_date ? \Carbon\Carbon::parse($result->result_date)->format('M d, Y') : 'N/A' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Processed By</div>
                    <div class="font-medium text-gray-700">
                        {{ $result->processedBy->name ?? 'N/A' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 uppercase">Status</div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'critical' => 'bg-red-100 text-red-800',
                        ];
                        $statusColor = $statusColors[$result->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium inline-block">
                        {{ ucfirst($result->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Results Section -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-line text-purple-600 mr-2"></i>
            Test Results
        </h3>

        @if($result->results)
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Summary</h4>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 whitespace-pre-wrap">{{ $result->results }}</div>
        </div>
        @endif

        @if($result->test_values && is_array($result->test_values) && count($result->test_values) > 0)
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Test Values</h4>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left text-gray-700 font-semibold">Parameter</th>
                            <th class="py-2 px-4 text-left text-gray-700 font-semibold">Value</th>
                            <th class="py-2 px-4 text-left text-gray-700 font-semibold">Unit</th>
                            <th class="py-2 px-4 text-left text-gray-700 font-semibold">Reference Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result->test_values as $value)
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">{{ $value['name'] ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $value['value'] ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $value['unit'] ?? '' }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $value['reference'] ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($result->findings)
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Findings</h4>
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 text-gray-800 whitespace-pre-wrap">{{ $result->findings }}</div>
        </div>
        @endif

        @if($result->recommendations)
        <div>
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Recommendations</h4>
            <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 text-gray-800 whitespace-pre-wrap">{{ $result->recommendations }}</div>
        </div>
        @endif

        @if(!$result->results && !$result->test_values && !$result->findings && !$result->recommendations)
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-hourglass-half text-3xl text-gray-300 mb-2"></i>
            <p>Results are being processed. Please check back later.</p>
        </div>
        @endif
    </div>

    <!-- Attached File -->
    @if($result->result_file)
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-paperclip text-gray-600 mr-2"></i>
            Attached Result
        </h3>

        <!-- File Preview -->
        <div class="mb-6">
            @php
                $extension = pathinfo($result->result_file, PATHINFO_EXTENSION);
                $fileUrl = Storage::disk('public')->url($result->result_file);
            @endphp

            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <div class="flex justify-center bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <img src="{{ $fileUrl }}" alt="Lab Result" class="max-w-full max-h-[800px] rounded shadow-sm">
                </div>
            @elseif(strtolower($extension) === 'pdf')
                <div class="w-full h-[800px] bg-gray-50 rounded-lg border border-gray-200">
                    <iframe src="{{ $fileUrl }}" class="w-full h-full rounded-lg"></iframe>
                </div>
            @else
                <div class="p-8 text-center bg-gray-50 rounded-lg border border-gray-200">
                    <i class="fas fa-file-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Preview not available for this file type.</p>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-file-pdf text-blue-600 text-xl"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-800">{{ basename($result->result_file) }}</div>
                    <div class="text-sm text-gray-500">Laboratory result document</div>
                </div>
            </div>
            <a href="{{ Storage::disk('public')->url($result->result_file) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                <i class="fas fa-external-link-alt"></i>
                <span>Open in New Tab</span>
            </a>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endpush
@endsection
