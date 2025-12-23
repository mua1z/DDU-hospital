@extends('lab.layouts.layout')

@section('title', 'Lab Technician Dashboard - DDU Clinics')
@section('page-title', __('Welcome, Lab Technician'))
@section('page-subtitle', __('Laboratory Dashboard'))

@section('content')
<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slide-up">
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Pending Tests') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['pending_tests'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-clock text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.pending-requests') }}" class="text-red-600 text-sm font-medium hover:underline">{{ __('View All') }} →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Today\'s Tests') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['today_tests'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-vial text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.process-test') }}" class="text-blue-600 text-sm font-medium hover:underline">{{ __('Process Now') }} →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Results Pending') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['results_pending'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-file-upload text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.upload-results') }}" class="text-yellow-600 text-sm font-medium hover:underline">{{ __('Upload Now') }} →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Critical Results') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['critical_results'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('lab.test-results') }}" class="text-red-600 text-sm font-medium hover:underline">{{ __('Review Now') }} →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pending Lab Requests -->
    <div class="animate-slide-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">{{ __('Pending Lab Requests') }}</h2>
                    <a href="{{ route('lab.pending-requests') }}" class="text-lab-primary hover:underline font-medium">{{ __('View All') }}</a>
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
                        @forelse($pendingRequests as $request)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <span class="font-mono font-bold text-gray-800">REQ{{ $request->id }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <span>{{ $request->patient->full_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $request->patient->card_number }}</span>
                            </td>
                            <td class="py-4 px-4">{{ $request->test_type }}</td>
                            <td class="py-4 px-4">
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('lab.process-test', $request->id) }}" class="px-4 py-2 bg-lab-primary text-white rounded-lg hover:bg-purple-700 transition text-sm">
                                    Start
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">
                                No pending requests
                            </td>
                        </tr>
                        @endforelse
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
                    <h2 class="text-xl font-bold text-gray-800">{{ __('Recently Processed') }}</h2>
                    <a href="{{ route('lab.test-results') }}" class="text-lab-primary hover:underline font-medium">{{ __('View All') }}</a>
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
                        @forelse($recentResults as $result)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-green-600 text-sm"></i>
                                    </div>
                                    <span>{{ $result->patient->full_name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $result->patient->card_number }}</span>
                            </td>
                            <td class="py-4 px-4">{{ $result->labRequest->test_type }}</td>
                            <td class="py-4 px-4">{{ $result->test_date }}</td>
                            <td class="py-4 px-4">
                                <a href="{{ route('lab.test-results') }}" class="text-lab-primary hover:underline font-medium">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No recent results
                            </td>
                        </tr>
                        @endforelse
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