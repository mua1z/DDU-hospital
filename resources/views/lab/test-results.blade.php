@extends('lab.layouts.layout')

@section('title', 'Test Results - DDU Clinics')
@section('page-title', 'Test Results')
@section('page-subtitle', 'View all lab test results')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">All Test Results</h2>
            <a href="{{ route('lab.upload-results') }}" class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-upload mr-2"></i> Upload Results
            </a>
        </div>
        
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
                    @forelse($results as $result)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <span class="font-mono font-bold text-gray-800">{{ $result->labRequest->request_number ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>{{ $result->patient->full_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $result->patient->card_number }}</span>
                        </td>
                        <td class="py-4 px-4">{{ $result->labRequest->test_type ?? 'N/A' }}</td>
                        <td class="py-4 px-4">{{ $result->test_date->format('M d, Y') }}</td>
                        <td class="py-4 px-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'critical' => 'bg-red-100 text-red-800',
                                ];
                                $statusColor = $statusColors[$result->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $statusColor }} py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst($result->status) }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <a href="#" class="text-lab-primary hover:underline font-medium">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">No test results found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection

