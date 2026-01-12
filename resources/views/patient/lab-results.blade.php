@extends('patient.layouts.layout')

@section('title', 'My Lab Results - DDU Clinics')
@section('page-title', 'My Lab Results')
@section('page-subtitle', 'View your laboratory test results')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">All Lab Results</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Request #</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test Type</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test Date</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Requested By</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Result</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labResults as $result)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <span class="font-mono font-medium text-gray-800">{{ $result->labRequest->request_number ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-semibold text-gray-800">{{ $result->labRequest->test_type ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-4">
                            {{ $result->test_date ? $result->test_date->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="py-4 px-4">
                            {{ $result->labRequest->requestedBy->name ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'critical' => 'bg-red-100 text-red-800',
                                ];
                                $statusColor = $statusColors[$result->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ ucfirst($result->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            @if($result->results)
                                <span class="text-gray-700">{{ Str::limit($result->results, 20) }}</span>
                            @elseif($result->result_file)
                                <span class="text-blue-600"><i class="fas fa-file-pdf mr-1"></i>File Attached</span>
                            @else
                                <span class="text-gray-400">Pending</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex space-x-2">
                                @if($result->result_file)
                                <a href="{{ Storage::disk('public')->url($result->result_file) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 transition" 
                                   title="View File">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @endif
                                <a href="{{ route('patient.lab-result-details', $result->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    View Details
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            <i class="fas fa-flask text-3xl text-gray-300 mb-2"></i>
                            <p>No lab results found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $labResults->links() }}
        </div>
    </div>
</div>
@endsection
