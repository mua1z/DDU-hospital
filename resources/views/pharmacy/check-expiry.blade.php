@extends('pharmacy.layouts.layout')

@section('title', 'Check Expiry - DDU Clinics')
@section('page-title', 'Check Expiry Dates')
@section('page-subtitle', 'Monitor medication expiry dates')

@section('content')
<div class="animate-slide-up">
    <!-- Expiring Soon -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Expiring Within 30 Days</h2>
            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">{{ $expiringSoon->count() }} items</span>
        </div>
        
        @if($expiringSoon->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-pharma-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Medication</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Batch No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Quantity</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Expiry Date</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Days Remaining</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expiringSoon as $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ $item->medication->name }}</div>
                            <div class="text-gray-600 text-xs">{{ $item->medication->strength ?? '' }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-mono text-sm">{{ $item->batch_number ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-4 font-bold">{{ $item->quantity }}</td>
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ $item->expiry_date->format('Y-m-d') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">
                                {{ $item->expiry_date->diffInDays(now()) }} days
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('pharmacy.inventory-management') }}" class="text-pharma-primary hover:underline font-medium">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-check-circle text-green-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No items expiring within 30 days</p>
        </div>
        @endif
    </div>
    
    <!-- Expired Items -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Expired Items</h2>
            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">{{ $expired->count() }} items</span>
        </div>
        
        @if($expired->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-pharma-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Medication</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Batch No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Quantity</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Expiry Date</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Days Expired</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expired as $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ $item->medication->name }}</div>
                            <div class="text-gray-600 text-xs">{{ $item->medication->strength ?? '' }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-mono text-sm">{{ $item->batch_number ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-4 font-bold">{{ $item->quantity }}</td>
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ $item->expiry_date->format('Y-m-d') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">
                                {{ now()->diffInDays($item->expiry_date) }} days ago
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <a href="{{ route('pharmacy.inventory-management') }}" class="text-pharma-primary hover:underline font-medium">Remove</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-check-circle text-green-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No expired items</p>
        </div>
        @endif
    </div>
</div>
@endsection

