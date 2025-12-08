@extends('lab.layouts.layout')

@section('title', 'Quality Control - DDU Clinics')
@section('page-title', 'Quality Control')
@section('page-subtitle', 'QC tests and calibration records')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Quality Control</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="p-6 bg-purple-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">QC Tests Today</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">--</h3>
                    </div>
                    <i class="fas fa-clipboard-check text-purple-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="p-6 bg-green-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Passed Tests</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">--</h3>
                    </div>
                    <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="p-6 bg-red-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Failed Tests</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">--</h3>
                    </div>
                    <i class="fas fa-times-circle text-red-600 text-3xl"></i>
                </div>
            </div>
        </div>
        
        <div class="text-center py-12">
            <i class="fas fa-clipboard-check text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">Quality control management coming soon</p>
        </div>
    </div>
</div>
@endsection

