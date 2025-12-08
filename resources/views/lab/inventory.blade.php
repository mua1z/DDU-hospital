@extends('lab.layouts.layout')

@section('title', 'Lab Inventory - DDU Clinics')
@section('page-title', 'Laboratory Inventory')
@section('page-subtitle', 'Manage lab supplies and equipment')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Lab Inventory</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="p-6 bg-blue-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Supplies</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">--</h3>
                    </div>
                    <i class="fas fa-boxes text-blue-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="p-6 bg-yellow-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Low Stock Items</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">--</h3>
                    </div>
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="p-6 bg-green-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Equipment Status</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">Operational</h3>
                    </div>
                    <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                </div>
            </div>
        </div>
        
        <div class="text-center py-12">
            <i class="fas fa-boxes text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">Lab inventory management coming soon</p>
        </div>
    </div>
</div>
@endsection

