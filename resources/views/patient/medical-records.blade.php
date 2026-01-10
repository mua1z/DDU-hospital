@extends('patient.layouts.layout')

@section('title', 'Medical History - Patient Portal')
@section('page-title', 'Medical History')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">My Medical Records</h2>
            <p class="text-sm text-gray-500">Comprehensive history of your visits and treatments</p>
        </div>
        <div>
            <!-- Filters could go here -->
        </div>
    </div>

    <!-- Timeline View -->
    <div class="p-6">
        @if($records->count() > 0)
            <div class="relative border-l-2 border-blue-200 ml-3 space-y-8 pl-8 py-2">
                @foreach($records as $record)
                    <div class="relative">
                        <!-- Dot -->
                        <div class="absolute -left-[41px] bg-white border-4 border-blue-500 w-6 h-6 rounded-full"></div>
                        
                        <!-- Content -->
                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2 mb-3">
                                <div>
                                    <span class="text-sm text-blue-600 font-bold tracking-wide uppercase mb-1 block">
                                        {{ $record->created_at->format('d M Y') }} • {{ $record->created_at->format('h:i A') }}
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ is_array($record->diagnosis) ? implode(', ', $record->diagnosis) : ($record->diagnosis ?? 'Medical Consultation') }}
                                    </h3>
                                </div>
                                <div class="flex items-center text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                                    <i class="fas fa-user-md mr-2"></i>
                                    <span>Dr. {{ $record->doctor ? $record->doctor->name : 'Unknown' }}</span>
                                </div>
                            </div>
                            
                            <div class="prose prose-sm text-gray-600 max-w-none">
                                <p><strong>Symptoms/Complaints:</strong> {{ $record->symptoms ?? 'N/A' }}</p>
                                
                                @if($record->physical_examination)
                                <p><strong>Physical Exam:</strong> {{ $record->physical_examination }}</p>
                                @endif
                                
                                @if($record->treatment_plan)
                                <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <strong class="text-blue-800 block mb-1">Treatment Plan:</strong>
                                    {{ $record->treatment_plan }}
                                </div>
                                @endif
                            </div>
                            
                            @if(isset($record->prescriptions) && $record->prescriptions->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <h4 class="text-sm font-bold text-gray-700 mb-2"><i class="fas fa-pills mr-1"></i> Prescribed Medications</h4>
                                <ul class="list-disc list-inside text-sm text-gray-600">
                                    @foreach($record->prescriptions as $prescription)
                                        @foreach($prescription->items as $item)
                                        <li>{{ $item->medication->name ?? 'Medication' }} ({{ $item->dosage }}) - {{ $item->instruction }}</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $records->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No Medical Records Found</h3>
                <p class="text-gray-500 mt-1">You haven't had any recorded visits yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
