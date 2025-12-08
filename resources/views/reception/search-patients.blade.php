@extends('reception.layouts.layout')

@section('title', 'Search Patients - DDU Clinics')
@section('page-title', 'Search Patients')
@section('page-subtitle', 'Find patient records')

@section('content')
<div class="animate-slide-up">
    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Search Criteria</h2>
        
        <form action="{{ route('reception.search-patients') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Search</label>
                    <input type="text" name="q" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="Name, Card No., or Phone..." value="{{ $query ?? '' }}">
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-ddu-primary text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                    <i class="fas fa-search"></i>
                    <span>Search Patients</span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Search Results -->
    @if(isset($patients) && $patients->count() > 0)
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Search Results ({{ $patients->total() }} Patients)</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Patient Name</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Card No.</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Phone</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Gender</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Registered</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $patient->full_name }}</div>
                                    @if($patient->date_of_birth)
                                    <div class="text-gray-600 text-sm">{{ ucfirst($patient->gender ?? 'N/A') }}, {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">{{ $patient->card_number }}</span>
                        </td>
                        <td class="py-4 px-4">{{ $patient->phone ?? 'N/A' }}</td>
                        <td class="py-4 px-4">{{ ucfirst($patient->gender ?? 'N/A') }}</td>
                        <td class="py-4 px-4">{{ $patient->created_at->format('M d, Y') }}</td>
                        <td class="py-4 px-4">
                            <a href="{{ route('reception.view-patient', $patient->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 border-t">
            {{ $patients->links() }}
        </div>
    </div>
    @elseif(isset($query) && $query)
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-gray-600">No patients found matching your search criteria.</p>
    </div>
    @endif
</div>
@endsection