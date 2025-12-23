@extends('lab.layouts.layout')

@section('title', 'Pending Requests - DDU Clinics')
@section('page-title', 'Pending Lab Requests')
@section('page-subtitle', 'Manage laboratory test requests')

@section('content')
<div class="animate-slade-up">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <button class="px-4 py-2 bg-lab-primary text-white rounded-lg font-medium">All Pending</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Urgent</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Routine</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Stat</button>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search by request ID or patient..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lab-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button class="px-4 py-2 border border-lab-primary text-lab-primary rounded-lg hover:bg-purple-50">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>
    </div>
    
    <!-- Pending Requests Table -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Pending Lab Requests ({{ $requests->total() }})</h2>
                <div class="text-gray-600">
                    <span class="text-red-600 font-bold">{{ $requests->where('priority', 'urgent')->count() + $requests->where('priority', 'critical')->count() }} Urgent</span> | 
                    <span class="text-yellow-600 font-bold">{{ $requests->where('priority', 'normal')->count() }} Routine</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-lab-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Request ID</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Patient Details</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Test Type</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Requested By</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Priority</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Time Received</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div class="font-mono font-bold text-gray-800">{{ $request->request_number }}</div>
                            @if($request->priority == 'urgent' || $request->priority == 'critical')
                            <div class="text-xs text-red-600 font-medium mt-1">STAT</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $request->patient->full_name }}</div>
                                    <div class="text-gray-600 text-sm">{{ $request->patient->card_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded mr-1">
                                {{ $request->test_type }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="font-medium">{{ $request->requestedBy->name ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $priorityColors = [
                                    'urgent' => 'bg-red-100 text-red-800',
                                    'critical' => 'bg-red-100 text-red-800',
                                    'normal' => 'bg-yellow-100 text-yellow-800',
                                ];
                                $priorityColor = $priorityColors[$request->priority] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="{{ $priorityColor }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ ucfirst($request->priority) }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="font-medium">{{ $request->requested_date->format('M d, Y') }}</div>
                                <div class="text-gray-600">{{ $request->created_at->format('h:i A') }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <a href="{{ route('lab.view-request-details', $request->id) }}" class="px-3 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm flex items-center" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('lab.process-test-id', $request->id) }}" class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition text-sm flex items-center space-x-2">
                                    <i class="fas fa-play"></i>
                                    <span>Start</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">No pending requests</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 border-t">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
