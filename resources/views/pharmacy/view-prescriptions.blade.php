@extends('pharmacy.layouts.layout')

@section('title', 'View Prescriptions - DDU Clinics')
@section('page-title', 'View Prescriptions')
@section('page-subtitle', 'Review and manage prescriptions')

@section('content')
<div class="animate-slade-up">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <button class="px-4 py-2 bg-pharma-primary text-white rounded-lg font-medium">All Prescriptions</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Pending</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Dispensed</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancelled</button>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search by prescription ID or patient..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pharma-primary">
            </div>
        </div>
    </div>
    
    <!-- Prescriptions Table -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Prescriptions (12 Total)</h2>
                <div class="text-gray-600">
                    <span class="text-blue-600 font-bold">8 Pending</span> | 
                    <span class="text-green-600 font-bold">4 Dispensed</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-pharma-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Prescription ID</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Patient Details</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Medications</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Prescribing Doctor</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Date</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div class="font-mono font-bold text-gray-800">{{ $prescription['id'] }}</div>
                            <div class="text-gray-600 text-xs">{{ $prescription['pharmacy'] }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full {{ $prescription['patientBgColor'] }} flex items-center justify-center mr-3">
                                    <i class="fas fa-user {{ $prescription['patientTextColor'] }}"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $prescription['patient'] }}</div>
                                    <div class="text-gray-600 text-sm">{{ $prescription['cardNo'] }} • {{ $prescription['age'] }} • {{ $prescription['gender'] }}</div>
                                    <div class="text-gray-600 text-xs">{{ $prescription['diagnosis'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                @foreach($prescription['medications'] as $med)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-800">{{ $med['name'] }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-600 text-sm">{{ $med['dosage'] }}</span>
                                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">{{ $med['quantity'] }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="font-medium">{{ $prescription['doctor'] }}</div>
                                <div class="text-gray-600 text-xs">{{ $prescription['doctorDept'] }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-sm">
                                <div class="font-medium">{{ $prescription['date'] }}</div>
                                <div class="text-gray-600">{{ $prescription['time'] }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="{{ $prescription['statusClass'] }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ $prescription['status'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                @if($prescription['status'] === 'Pending')
                                <a href="{{ route('pharmacy.dispense-medications') }}" class="px-4 py-2 bg-pharma-primary text-white rounded-lg hover:bg-red-700 transition text-sm">
                                    Dispense
                                </a>
                                @elseif($prescription['status'] === 'Dispensed')
                                <button class="px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm">
                                    <i class="fas fa-check mr-1"></i> Done
                                </button>
                                @endif
                                <button class="p-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 border-t flex justify-between items-center">
            <div class="text-gray-600">Showing 1-6 of 12 prescriptions</div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Previous</button>
                <button class="px-3 py-1 bg-pharma-primary text-white rounded-lg">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection

@php
$prescriptions = [
    [
        'id' => 'RX0034',
        'patient' => 'Ruth Asnake',
        'cardNo' => 'STU1102',
        'age' => '21 years',
        'gender' => 'Female',
        'diagnosis' => 'Upper Respiratory Infection',
        'medications' => [
            ['name' => 'Amoxicillin 250mg', 'dosage' => '1 tab TDS', 'quantity' => '21 tabs'],
            ['name' => 'Paracetamol 500mg', 'dosage' => '1 tab PRN', 'quantity' => '10 tabs']
        ],
        'doctor' => 'Dr. Ahmed Ali',
        'doctorDept' => 'General Medicine',
        'date' => 'Today',
        'time' => '09:15 AM',
        'status' => 'Pending',
        'statusClass' => 'bg-blue-100 text-blue-800',
        'pharmacy' => 'Main Campus',
        'patientBgColor' => 'bg-pink-100',
        'patientTextColor' => 'text-pink-600'
    ],
    [
        'id' => 'RX0035',
        'patient' => 'Salem Asfaw',
        'cardNo' => 'STU0150',
        'age' => '21 years',
        'gender' => 'Male',
        'diagnosis' => 'Fever & Cough',
        'medications' => [
            ['name' => 'Paracetamol 500mg', 'dosage' => '1 tab QID', 'quantity' => '20 tabs'],
            ['name' => 'Cough Syrup', 'dosage' => '10ml TDS', 'quantity' => '100ml']
        ],
        'doctor' => 'Dr. Hana Girma',
        'doctorDept' => 'General Medicine',
        'date' => 'Today',
        'time' => '10:30 AM',
        'status' => 'Pending',
        'statusClass' => 'bg-blue-100 text-blue-800',
        'pharmacy' => 'Main Campus',
        'patientBgColor' => 'bg-blue-100',
        'patientTextColor' => 'text-blue-600'
    ],
    [
        'id' => 'RX0036',
        'patient' => 'Marta Solomon',
        'cardNo' => 'STU0224',
        'age' => '22 years',
        'gender' => 'Female',
        'diagnosis' => 'Gastric Ulcer',
        'medications' => [
            ['name' => 'Omeprazole 20mg', 'dosage' => '1 tab OD', 'quantity' => '30 tabs'],
            ['name' => 'Antacid', 'dosage' => '10ml PRN', 'quantity' => '200ml']
        ],
        'doctor' => 'Dr. Markos',
        'doctorDept' => 'Gastroenterology',
        'date' => 'Yesterday',
        'time' => '03:45 PM',
        'status' => 'Dispensed',
        'statusClass' => 'bg-green-100 text-green-800',
        'pharmacy' => 'West Campus',
        'patientBgColor' => 'bg-purple-100',
        'patientTextColor' => 'text-purple-600'
    ],
    [
        'id' => 'RX0037',
        'patient' => 'Kebede Abebe',
        'cardNo' => 'STU0225',
        'age' => '20 years',
        'gender' => 'Male',
        'diagnosis' => 'Allergic Reaction',
        'medications' => [
            ['name' => 'Cetirizine 10mg', 'dosage' => '1 tab OD', 'quantity' => '10 tabs'],
            ['name' => 'Hydrocortisone Cream', 'dosage' => 'Apply BID', 'quantity' => '30g']
        ],
        'doctor' => 'Dr. Sara',
        'doctorDept' => 'Dermatology',
        'date' => 'Yesterday',
        'time' => '11:20 AM',
        'status' => 'Pending',
        'statusClass' => 'bg-blue-100 text-blue-800',
        'pharmacy' => 'Main Campus',
        'patientBgColor' => 'bg-green-100',
        'patientTextColor' => 'text-green-600'
    ],
    [
        'id' => 'RX0038',
        'patient' => 'Mohammed Dawud',
        'cardNo' => 'STU0187',
        'age' => '23 years',
        'gender' => 'Male',
        'diagnosis' => 'Headache',
        'medications' => [
            ['name' => 'Ibuprofen 400mg', 'dosage' => '1 tab PRN', 'quantity' => '10 tabs']
        ],
        'doctor' => 'Dr. Ahmed Ali',
        'doctorDept' => 'General Medicine',
        'date' => '2 days ago',
        'time' => '02:15 PM',
        'status' => 'Dispensed',
        'statusClass' => 'bg-green-100 text-green-800',
        'pharmacy' => 'Main Campus',
        'patientBgColor' => 'bg-orange-100',
        'patientTextColor' => 'text-orange-600'
    ],
    [
        'id' => 'RX0039',
        'patient' => 'Liya Akiliu',
        'cardNo' => 'STU0921',
        'age' => '20 years',
        'gender' => 'Female',
        'diagnosis' => 'Malaria',
        'medications' => [
            ['name' => 'Artemether-Lumefantrine', 'dosage' => '4 tabs BID', 'quantity' => '24 tabs'],
            ['name' => 'Paracetamol 500mg', 'dosage' => '1 tab QID', 'quantity' => '20 tabs']
        ],
        'doctor' => 'Dr. Ahmed Ali',
        'doctorDept' => 'General Medicine',
        'date' => '2 days ago',
        'time' => '04:30 PM',
        'status' => 'Cancelled',
        'statusClass' => 'bg-gray-100 text-gray-800',
        'pharmacy' => 'Main Campus',
        'patientBgColor' => 'bg-red-100',
        'patientTextColor' => 'text-red-600'
    ],
];
@endphp