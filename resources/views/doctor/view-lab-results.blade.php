@extends('doctor.layouts.layout')

@section('title', 'Lab Results - DDU Clinics')
@section('page-title', 'Laboratory Results')
@section('page-subtitle', 'Review and analyze test results')

@section('content')
<div class="animate-slide-up">
    <!-- Filters and Search -->
    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col gap-4">
            <!-- Filter Groups -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Time Filters -->
                <div class="flex items-center space-x-2 mr-4 border-r pr-4 border-gray-200">
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'today']) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('period') === 'today' ? 'bg-ddu-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Today
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'tomorrow']) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('period') === 'tomorrow' ? 'bg-ddu-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Tomorrow
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['period' => 'this_week']) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('period') === 'this_week' ? 'bg-ddu-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        This Week
                    </a>
                </div>

                <!-- Status Filters -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('doctor.view-lab-results', request()->except(['status', 'period', 'page'])) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ !request('status') && !request('period') ? 'bg-gray-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        All Results
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Pending
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('status') === 'completed' ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Completed
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'abnormal']) }}" 
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('status') === 'abnormal' ? 'bg-red-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Abnormal
                    </a>
                </div>
            </div>
            
            <!-- Search Bar -->
            <form action="{{ route('doctor.view-lab-results') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Preserve Filters -->
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('period')) <input type="hidden" name="period" value="{{ request('period') }}"> @endif

                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by patient or test..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex gap-2">
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                    @if(request()->anyFilled(['search', 'date', 'status', 'period']))
                        <a href="{{ route('doctor.view-lab-results') }}" class="px-4 py-2 text-gray-500 hover:text-red-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition" title="Clear All Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Latest Results Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Latest Test Results</h2>
                        <span class="text-gray-600">
                            Total: {{ $labResults->total() }} {{ \Illuminate\Support\Str::plural('test', $labResults->total()) }}
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Patient</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Test</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Collected</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Lab Tech</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Result</th>
                                <th class="px-4 py-3 text-right font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($labResults as $result)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 align-top">
                                        <div class="font-semibold text-gray-900">
                                            {{ optional($result->patient)->full_name ?? 'Unknown patient' }}
                                        </div>
                                        @if($result->patient)
                                            <div class="text-xs text-gray-600">
                                                Card: {{ $result->patient->card_number }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ ucfirst($result->patient->gender) }} ·
                                                DOB: {{ \Illuminate\Support\Carbon::parse($result->patient->date_of_birth)->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-4 py-3 align-top">
                                        <div class="font-bold text-gray-800">
                                            {{ optional($result->labRequest)->test_type ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs font-mono text-gray-500 mt-1">
                                            {{ optional($result->labRequest)->request_number }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top text-sm">
                                        <div class="text-gray-900">
                                            {{ optional($result->test_date)->format('M d, Y') }}
                                        </div>
                                        @if($result->result_date)
                                            <div class="text-xs text-gray-500 mt-1">
                                                Result: {{ $result->result_date->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 align-top text-sm text-gray-700">
                                        @if($result->processedBy)
                                            {{ $result->processedBy->name }}
                                        @else
                                            <span class="text-xs text-gray-400">--</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 align-top">
                                        @php
                                            $statusClass = match($result->status) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'critical' => 'bg-red-100 text-red-800',
                                                default => 'bg-yellow-100 text-yellow-800',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($result->status) }}
                                        </span>
                                    </td>

                                    @php
                                        $rawResult = strtolower(trim((string) ($result->results ?? '')));
                                        $simpleResult = $rawResult === 'positive' ? 'positive'
                                            : ($rawResult === 'negative' ? 'negative' : null);
                                        
                                        if ($simpleResult) {
                                            $resultClass = match($simpleResult) {
                                                'positive' => 'bg-red-100 text-red-800',
                                                'negative' => 'bg-green-100 text-green-800',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                            $label = ucfirst($simpleResult);
                                        } elseif (!empty($result->results)) {
                                            $resultClass = 'bg-gray-100 text-gray-700';
                                            $label = Str::limit($result->results, 20);
                                        } elseif ($result->result_file) {
                                            $resultClass = 'bg-blue-100 text-blue-800';
                                            $label = 'File Attached';
                                        } else {
                                            $resultClass = 'bg-gray-100 text-gray-400';
                                            $label = 'Pending';
                                        }
                                    @endphp
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $resultClass }}">
                                            @if($label === 'File Attached')
                                                <i class="fas fa-paperclip mr-1"></i>
                                            @endif
                                            {{ $label }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 align-top text-right">
                                        <div class="flex justify-end space-x-2">
                                            @if($result->result_file)
                                                <a href="{{ Storage::disk('public')->url($result->result_file) }}"
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-800 transition" title="View PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('doctor.view-result-details', $result->id) }}"
                                                class="text-ddu-primary hover:text-blue-800 transition flex items-center" title="View Details">
                                                 <i class="fas fa-eye"></i>
                                             </a>

                                            <a href="{{ route('doctor.write-prescription', ['patient_id' => $result->patient_id]) }}"
                                               class="text-green-600 hover:text-green-800 transition" title="Write Prescription">
                                                <i class="fas fa-prescription"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 text-sm">
                                        No lab results found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($labResults instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="px-6 py-4 border-t">
                        {{ $labResults->links() }}
                    </div>
                @endif
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
                            <span class="font-bold text-gray-800">{{ $labStats['tests_today']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $labStats['tests_today']['percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Abnormal Results</span>
                            <span class="font-bold text-red-600">{{ $labStats['abnormal']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $labStats['abnormal']['percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Pending Review</span>
                            <span class="font-bold text-yellow-600">{{ $labStats['pending']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $labStats['pending']['percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Completed Today</span>
                            <span class="font-bold text-green-600">{{ $labStats['completed_today']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $labStats['completed_today']['percent'] }}%"></div>
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