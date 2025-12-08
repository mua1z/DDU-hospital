@extends('doctor.layouts.layout')

@section('title', 'Request Lab Test - DDU Clinics')
@section('page-title', 'Request Laboratory Test')
@section('page-subtitle', 'Order tests for patients')

@section('content')
<div class="animate-slade-up">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Select Patient & Tests</h2>
        
        <form action="#" method="POST" class="space-y-6">
            <!-- Patient Selection -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2">Patient Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Select Patient *</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                            <option value="">Search or select patient</option>
                            <option value="1">Salem Asfaw (STU0150) - Fever & Cough</option>
                            <option value="2">Marta Solomon (STU0224) - Abdominal Pain</option>
                            <option value="3">Mohammed Dawud (STU0187) - Headache</option>
                            <option value="4">Kebede Abebe (STU0225) - Allergy</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Patient ID</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="STU0150" readonly>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Age</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="21 years" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="Male" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Department</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="Computer Science" readonly>
                    </div>
                </div>
            </div>
            
            <!-- Test Selection -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2">Select Laboratory Tests</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Blood Tests -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-800 flex items-center">
                            <i class="fas fa-tint text-red-500 mr-2"></i> Blood Tests
                        </h4>
                        <div class="space-y-2">
                            @foreach(['Complete Blood Count (CBC)', 'Blood Glucose', 'Lipid Profile', 'Liver Function Test', 'Kidney Function Test', 'Thyroid Function Test'] as $test)
                            <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                <input type="checkbox" class="rounded text-blue-600">
                                <span class="text-gray-700">{{ $test }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Other Tests -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-800 flex items-center">
                            <i class="fas fa-vial text-green-500 mr-2"></i> Other Tests
                        </h4>
                        <div class="space-y-2">
                            @foreach(['Urine Analysis', 'Stool Test', 'Covid-19 Test', 'Malaria Test', 'HIV Test', 'Pregnancy Test'] as $test)
                            <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer">
                                <input type="checkbox" class="rounded text-blue-600">
                                <span class="text-gray-700">{{ $test }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Custom Test Request -->
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Additional Test Instructions</label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Specify any special instructions or custom tests..."></textarea>
                </div>
            </div>
            
            <!-- Urgency & Notes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2">Priority & Urgency</h3>
                    
                    <div class="space-y-3">
                        @foreach([
                            ['value' => 'routine', 'label' => 'Routine', 'desc' => 'Results within 24-48 hours'],
                            ['value' => 'urgent', 'label' => 'Urgent', 'desc' => 'Results within 2-6 hours'],
                            ['value' => 'stat', 'label' => 'STAT (Immediate)', 'desc' => 'Results within 1 hour'],
                        ] as $priority)
                        <label class="flex items-start space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300">
                            <input type="radio" name="priority" value="{{ $priority['value'] }}" class="mt-1">
                            <div>
                                <div class="font-medium text-gray-800">{{ $priority['label'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $priority['desc'] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2">Clinical Notes</h3>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Reason for Testing</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="4" placeholder="Describe symptoms, suspected diagnosis, or clinical findings..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Suspecting Diagnosis</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., Urinary Tract Infection, Anemia, etc.">
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Submit Lab Request</span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Recent Lab Requests -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Recent Lab Requests</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Request ID</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Patient</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Tests</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Date</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Priority</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-gray-800">LAB-2024-0012</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <span>Salem Asfaw</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">CBC</span>
                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded text-xs">Glucose</span>
                                <span class="bg-purple-100 text-purple-800 py-1 px-2 rounded text-xs">Covid-19</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">Today, 08:45 AM</td>
                        <td class="py-4 px-6">
                            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">Urgent</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm font-medium">Processing</span>
                        </td>
                    </tr>
                    
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-gray-800">LAB-2024-0011</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-pink-600 text-sm"></i>
                                </div>
                                <span>Marta Solomon</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">Urine Test</span>
                                <span class="bg-red-100 text-red-800 py-1 px-2 rounded text-xs">Pregnancy</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">Yesterday, 03:30 PM</td>
                        <td class="py-4 px-6">
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Routine</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Completed</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection