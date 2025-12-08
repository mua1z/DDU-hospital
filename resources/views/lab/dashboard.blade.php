@extends('lab.layouts.layout')

@section('title', 'Lab Technician Dashboard - DDU Clinics')
@section('page-title', 'Welcome, Lab Technician')
@section('page-subtitle', 'Laboratory Dashboard')

@section('content')
<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slide-up">
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Pending Tests</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">8</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-clock text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.pending-requests') }}" class="text-red-600 text-sm font-medium hover:underline">View All →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Today's Tests</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">15</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-vial text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.process-test') }}" class="text-blue-600 text-sm font-medium hover:underline">Process Now →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Results Pending</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">3</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-file-upload text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.upload-results') }}" class="text-yellow-600 text-sm font-medium hover:underline">Upload Now →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Critical Results</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">2</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.test-results') }}" class="text-red-600 text-sm font-medium hover:underline">Review Now →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pending Lab Requests -->
    <div class="animate-slide-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Pending Lab Requests</h2>
                    <a href="{{ route('lab.pending-requests') }}" class="text-lab-primary hover:underline font-medium">View All</a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-lab-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Request ID</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Student</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test Type</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Status</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <span class="font-mono font-bold text-gray-800">REQ1021</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <span>Liya Akiliu</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">STU0921</span>
                            </td>
                            <td class="py-4 px-4">Malaria Smear</td>
                            <td class="py-4 px-4">
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">In Queue</span>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('lab.process-test') }}" class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition text-sm">
                                    Start
                                </a>
                            </td>
                        </tr>
                        
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <span class="font-mono font-bold text-gray-800">REQ1022</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-green-600 text-sm"></i>
                                    </div>
                                    <span>Robel Bekele</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">STU0817</span>
                            </td>
                            <td class="py-4 px-4">Urinalysis</td>
                            <td class="py-4 px-4">
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">In Queue</span>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('lab.process-test') }}" class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition text-sm">
                                    Start
                                </a>
                            </td>
                        </tr>
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <span class="font-mono font-bold text-gray-800">REQ1023</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-pink-600 text-sm"></i>
                                    </div>
                                    <span>Kebede Abebe</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">STU0225</span>
                            </td>
                            <td class="py-4 px-4">Blood Count</td>
                            <td class="py-4 px-4">
                                <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm font-medium">Processing</span>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('lab.upload-results') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                                    Upload
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Recently Processed -->
    <div class="animate-slide-up" style="animation-delay: 0.2s">
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Recently Processed</h2>
                    <a href="{{ route('lab.test-results') }}" class="text-lab-primary hover:underline font-medium">View All</a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-lab-light">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Student</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Test</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>
                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <span>Selam Tadesse</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">STU0723</span>
                            </td>
                            <td class="py-4 px-4">Blood Count</td>
                            <td class="py-4 px-4">2025-06-03</td>
                            <td class="py-4 px-4">
                                <a href="#" class="text-lab-primary hover:underline font-medium">View</a>
                            </td>
                        </tr>
                        
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-green-600 text-sm"></i>
                                    </div>
                                    <span>Mohammed Dawud</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">STU0187</span>
                            </td>
                            <td class="py-4 px-4">Covid-19 Test</td>
                            <td class="py-4 px-4">2025-06-02</td>
                            <td class="py-4 px-4">
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Negative</span>
                            </td>
                        </tr>
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-red-600 text-sm"></i>
                                    </div>
                                    <span>Marta Solomon</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">STU0224</span>
                            </td>
                            <td class="py-4 px-4">Pregnancy Test</td>
                            <td class="py-4 px-4">2025-06-01</td>
                            <td class="py-4 px-4">
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-sm font-medium">Positive</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 animate-slide-up" style="animation-delay: 0.3s">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('lab.process-test') }}" class="dashboard-card bg-white border border-blue-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-blue-300 hover:bg-blue-50 transition">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                    <i class="fas fa-vial text-blue-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Process Test</h3>
                <p class="text-gray-600 text-sm">Start new test processing</p>
            </a>
            
            <a href="{{ route('lab.upload-results') }}" class="dashboard-card bg-white border border-green-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-green-300 hover:bg-green-50 transition">
                <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                    <i class="fas fa-upload text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Upload Results</h3>
                <p class="text-gray-600 text-sm">Upload test results</p>
            </a>
            
            <a href="{{ route('lab.inventory') }}" class="dashboard-card bg-white border border-yellow-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-yellow-300 hover:bg-yellow-50 transition">
                <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mb-4">
                    <i class="fas fa-boxes text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Check Inventory</h3>
                <p class="text-gray-600 text-sm">View lab supplies</p>
            </a>
            
            <a href="{{ route('lab.quality-control') }}" class="dashboard-card bg-white border border-purple-200 rounded-xl p-6 flex flex-col items-center text-center hover:border-purple-300 hover:bg-purple-50 transition">
                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                    <i class="fas fa-clipboard-check text-purple-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Quality Control</h3>
                <p class="text-gray-600 text-sm">Run QC tests</p>
            </a>
        </div>
    </div>
</div>

<!-- Equipment Status -->
<div class="mt-8 animate-slide-up" style="animation-delay: 0.4s">
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Equipment Status</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-medium text-gray-800">Centrifuge</h3>
                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Operational</span>
                    </div>
                    <div class="text-sm text-gray-600">Last calibrated: 2 days ago</div>
                </div>
                
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-medium text-gray-800">Microscope</h3>
                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Operational</span>
                    </div>
                    <div class="text-sm text-gray-600">In use: Malaria smear</div>
                </div>
                
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-medium text-gray-800">Blood Analyzer</h3>
                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">Maintenance</span>
                    </div>
                    <div class="text-sm text-gray-600">Scheduled: Tomorrow 10 AM</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection