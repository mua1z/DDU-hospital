@extends('pharmacy.layouts.layout')

@section('title', 'Generate Reports - DDU Clinics')
@section('page-title', 'Generate Reports')
@section('page-subtitle', 'Pharmacy reports and analytics')

@section('content')
<div class="animate-slide-up">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Dispensing Reports</h3>
            <div class="space-y-3">
                <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-800">Daily Dispensing Report</h4>
                            <p class="text-gray-600 text-sm">View today's dispensed medications</p>
                        </div>
                        <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                    </div>
                </a>
                
                <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-800">Monthly Report</h4>
                            <p class="text-gray-600 text-sm">Monthly dispensing summary</p>
                        </div>
                        <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Inventory Reports</h3>
            <div class="space-y-3">
                <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-800">Stock Report</h4>
                            <p class="text-gray-600 text-sm">Current inventory levels</p>
                        </div>
                        <i class="fas fa-file-excel text-green-600 text-2xl"></i>
                    </div>
                </a>
                
                <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-800">Expiry Report</h4>
                            <p class="text-gray-600 text-sm">Items expiring soon</p>
                        </div>
                        <i class="fas fa-file-excel text-green-600 text-2xl"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Custom Report</h2>
        <form action="#" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Report Type</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
                        <option value="">Select Report Type</option>
                        <option value="dispensing">Dispensing Report</option>
                        <option value="inventory">Inventory Report</option>
                        <option value="expiry">Expiry Report</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Date Range</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-3 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-download mr-2"></i> Generate Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

