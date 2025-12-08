@extends('doctor.layouts.layout')

@section('title', 'Lab Results - DDU Clinics')
@section('page-title', 'Laboratory Results')
@section('page-subtitle', 'Review and analyze test results')

@section('content')
<div class="animate-slide-up">
    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <button class="px-4 py-2 bg-ddu-primary text-white rounded-lg font-medium">All Results</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Pending</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Completed</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Abnormal</button>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search by patient or test..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Pending Results -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Latest Test Results</h2>
                        <span class="text-gray-600">Total: 15 tests</span>
                    </div>
                </div>
                
                <div class="divide-y">
                    @foreach($labResults as $result)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 rounded-full {{ $result['bgColor'] }} flex items-center justify-center">
                                    <i class="{{ $result['icon'] }} {{ $result['textColor'] }} text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="font-bold text-gray-800">{{ $result['patient'] }}</h3>
                                        <span class="bg-gray-100 text-gray-800 py-1 px-2 rounded text-sm">{{ $result['testType'] }}</span>
                                        <span class="text-xs text-gray-500">{{ $result['requestId'] }}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                        @foreach($result['parameters'] as $param)
                                        <div class="bg-gray-50 p-2 rounded">
                                            <div class="text-xs text-gray-600">{{ $param['name'] }}</div>
                                            <div class="font-medium {{ $param['status'] === 'normal' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $param['value'] }}
                                                <span class="text-xs">{{ $param['unit'] }}</span>
                                            </div>
                                            <div class="text-xs {{ $param['status'] === 'normal' ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $param['status'] === 'normal' ? 'Normal' : 'Abnormal' }}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-clock mr-2"></i>
                                        Collected: {{ $result['collected'] }} | 
                                        <i class="fas fa-user-md ml-4 mr-2"></i>
                                        Lab Tech: {{ $result['technician'] }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end space-y-3">
                                <span class="{{ $result['statusClass'] }} py-1 px-3 rounded-full text-sm font-medium">
                                    {{ $result['status'] }}
                                </span>
                                
                                <div class="text-right">
                                    <div class="text-gray-800 font-medium">{{ $result['testDate'] }}</div>
                                    <div class="text-gray-600 text-sm">{{ $result['priority'] }}</div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>View PDF</span>
                                    </a>
                                    <a href="{{ route('doctor.write-prescription') }}" class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition">
                                        <i class="fas fa-prescription"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        @if($result['notes'])
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-yellow-500 mt-1 mr-2"></i>
                                <div class="text-sm text-gray-700">{{ $result['notes'] }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Lab Statistics -->
        <div>
            <div class="bg-white rounded-xl shadow mb-6">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold text-gray-800">Lab Statistics</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Tests Today</span>
                            <span class="font-bold text-gray-800">8</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 40%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Abnormal Results</span>
                            <span class="font-bold text-red-600">3</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Pending Review</span>
                            <span class="font-bold text-yellow-600">5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Completed Today</span>
                            <span class="font-bold text-green-600">12</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold text-gray-800">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="{{ route('doctor.request-lab-test') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-flask text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Request New Test</h3>
                                <p class="text-gray-600 text-sm">Order lab test</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-file-export text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Export Results</h3>
                                <p class="text-gray-600 text-sm">PDF/Excel format</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('doctor.write-prescription') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-prescription text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Prescribe Medication</h3>
                                <p class="text-gray-600 text-sm">Based on results</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('doctor.document-history') }}" class="flex items-center space-x-3 p-4 rounded-lg border border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition">
                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-history text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Update History</h3>
                                <p class="text-gray-600 text-sm">Add lab findings</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
$labResults = [
    [
        'patient' => 'Salem Asfaw',
        'testType' => 'Complete Blood Count',
        'requestId' => 'LAB-2024-0012',
        'parameters' => [
            ['name' => 'WBC', 'value' => '12.5', 'unit' => '10³/μL', 'status' => 'abnormal'],
            ['name' => 'RBC', 'value' => '4.8', 'unit' => '10⁶/μL', 'status' => 'normal'],
            ['name' => 'HGB', 'value' => '14.2', 'unit' => 'g/dL', 'status' => 'normal'],
            ['name' => 'PLT', 'value' => '350', 'unit' => '10³/μL', 'status' => 'normal'],
        ],
        'collected' => 'Today, 09:15 AM',
        'technician' => 'Dr. Sara',
        'testDate' => 'Dec 7, 2024',
        'priority' => 'Urgent',
        'status' => 'Completed',
        'statusClass' => 'bg-green-100 text-green-800',
        'icon' => 'fas fa-tint',
        'bgColor' => 'bg-red-100',
        'textColor' => 'text-red-600',
        'notes' => 'Elevated WBC indicates possible infection. Recommend follow-up.'
    ],
    [
        'patient' => 'Marta Solomon',
        'testType' => 'Urine Analysis + Pregnancy',
        'requestId' => 'LAB-2024-0011',
        'parameters' => [
            ['name' => 'pH', 'value' => '6.5', 'unit' => '', 'status' => 'normal'],
            ['name' => 'Glucose', 'value' => 'Negative', 'unit' => '', 'status' => 'normal'],
            ['name' => 'Protein', 'value' => 'Trace', 'unit' => '', 'status' => 'normal'],
            ['name' => 'Pregnancy', 'value' => 'Negative', 'unit' => '', 'status' => 'normal'],
        ],
        'collected' => 'Yesterday, 04:00 PM',
        'technician' => 'Dr. Markos',
        'testDate' => 'Dec 6, 2024',
        'priority' => 'Routine',
        'status' => 'Reviewed',
        'statusClass' => 'bg-blue-100 text-blue-800',
        'icon' => 'fas fa-vial',
        'bgColor' => 'bg-green-100',
        'textColor' => 'text-green-600',
        'notes' => null
    ],
    [
        'patient' => 'Kebede Abebe',
        'testType' => 'Allergy Panel',
        'requestId' => 'LAB-2024-0010',
        'parameters' => [
            ['name' => 'IgE Total', 'value' => '250', 'unit' => 'IU/mL', 'status' => 'abnormal'],
            ['name' => 'Dust Mite', 'value' => 'High', 'unit' => '', 'status' => 'abnormal'],
            ['name' => 'Pollen', 'value' => 'Moderate', 'unit' => '', 'status' => 'abnormal'],
            ['name' => 'Food', 'value' => 'Negative', 'unit' => '', 'status' => 'normal'],
        ],
        'collected' => 'Dec 5, 2024',
        'technician' => 'Dr. Sara',
        'testDate' => 'Dec 6, 2024',
        'priority' => 'Routine',
        'status' => 'Pending Review',
        'statusClass' => 'bg-yellow-100 text-yellow-800',
        'icon' => 'fas fa-allergies',
        'bgColor' => 'bg-yellow-100',
        'textColor' => 'text-yellow-600',
        'notes' => 'Strong reaction to dust mites. Consider antihistamine prescription.'
    ],
];
@endphp