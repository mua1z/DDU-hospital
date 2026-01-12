@extends('doctor.layouts.layout')

@section('title', 'Patient History - DDU Clinics')
@section('page-title', 'Document Patient History')
@section('page-subtitle', 'Record and update patient medical history')

@section('content')
<div class="animate-slide-up">
    <!-- Patient Selection -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Select Patient</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Search Patient *</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" id="patientSelect" onchange="window.location.href='?patient_id='+this.value">
                    <option value="">Search by name or ID</option>
                    @foreach($recentPatients as $p)
                        <option value="{{ $p->id }}" {{ (isset($patient) && $patient->id == $p->id) ? 'selected' : '' }}>
                            {{ $p->full_name }} ({{ $p->card_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Patient ID Display -->
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Patient ID</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $patient->card_number ?? '' }}" readonly>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Last Visit</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="{{ $patient && $patient->medicalRecords()->exists() ? $patient->medicalRecords()->latest('visit_date')->first()->visit_date->format('M d, Y') : 'N/A' }}" readonly>
            </div>
        </div>
    </div>

    @if($patient)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Medical History Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Current Visit Documentation</h2>

                <form action="{{ route('doctor.store-medical-record') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="visit_date" value="{{ now()->toDateString() }}">
                    
                    <!-- Chief Complaint -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-comment-medical mr-2"></i> Chief Complaint
                        </h3>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Presenting Symptoms *</label>
                            <textarea name="chief_complaint" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Describe the patient's main symptoms, duration, and severity..." required></textarea>
                        </div>
                    </div>

                    <!-- History of Present Illness -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-history mr-2"></i> History of Present Illness
                        </h3>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Detailed History *</label>
                            <textarea name="history_of_present_illness" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="4" placeholder="Chronological account of symptoms, progression, aggravating/alleviating factors..." required></textarea>
                        </div>
                    </div>

                    <!-- Physical Examination -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-stethoscope mr-2"></i> Physical Examination
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Vital Signs</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <div class="text-xs text-gray-600">Temperature</div>
                                        <input type="text" name="vital_signs[temperature]" class="w-full px-3 py-2 border border-gray-300 rounded" placeholder="e.g. 37.5">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">BP</div>
                                        <input type="text" name="vital_signs[bp]" class="w-full px-3 py-2 border border-gray-300 rounded" placeholder="120/80">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">Pulse</div>
                                        <input type="text" name="vital_signs[pulse]" class="w-full px-3 py-2 border border-gray-300 rounded" placeholder="bpm">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">Resp. Rate</div>
                                        <input type="text" name="vital_signs[resp_rate]" class="w-full px-3 py-2 border border-gray-300 rounded" placeholder="/min">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">BMI</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <div class="text-xs text-gray-600">Height (cm)</div>
                                        <input type="text" name="vital_signs[height]" class="w-full px-3 py-2 border border-gray-300 rounded">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">Weight (kg)</div>
                                        <input type="text" name="vital_signs[weight]" class="w-full px-3 py-2 border border-gray-300 rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Examination Findings *</label>
                            <textarea name="examination_findings" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="General appearance, system examination findings..." required></textarea>
                        </div>
                    </div>

                    <!-- Assessment & Plan -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-diagnoses mr-2"></i> Assessment & Plan
                        </h3>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Diagnosis *</label>
                            <div class="space-y-2 mb-2">
                                @foreach(['Upper Respiratory Infection', 'Viral Pharyngitis', 'Acute Bronchitis', 'Other'] as $diag)
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="diagnosis[]" value="{{ $diag }}" class="rounded text-blue-600">
                                    <span class="text-gray-700">{{ $diag }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Treatment Plan *</label>
                            <textarea name="treatment_plan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Medications prescribed, procedures, referrals, follow-up..." required></textarea>
                        </div>
                        
                        <div>
                             <label class="block text-gray-700 text-sm font-medium mb-2">Additional Notes</label>
                             <textarea name="notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <button type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Save to Medical Record</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Patient Summary & History -->
        <div>
            <!-- Patient Summary -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Patient Summary</h2>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">{{ $patient->full_name }}</h3>
                            <p class="text-gray-600">{{ $patient->card_number }} • {{ $patient->gender }}</p>
                            <p class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years old</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-4 border-t">
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-800">{{ $patient->medicalRecords->count() }}</div>
                            <div class="text-gray-600 text-sm">Visits</div>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t">
                        <h4 class="font-medium text-gray-800 mb-2">Known Allergies</h4>
                        <div class="text-sm text-gray-700">
                            {{ $patient->allergies ?? 'No known allergies' }}
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t">
                        <h4 class="font-medium text-gray-800 mb-2">History</h4>
                        <div class="text-sm text-gray-700">
                            {{ $patient->medical_history ?? 'No past history recorded' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visit History -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Past Medical Records</h2>

                <div class="space-y-4">
                    @forelse($visitHistory as $record)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium text-gray-800">{{ $record->visit_date->format('M d, Y') }}</div>
                                <div class="text-gray-600 text-sm">{{ Str::limit($record->chief_complaint, 30) }}</div>
                            </div>
                        </div>
                        <div class="text-gray-600 text-sm mt-1">{{ $record->doctor->name ?? 'Doctor' }}</div>
                        <div class="mt-2 text-xs text-gray-500">
                             Diagnosis: {{ implode(', ', $record->diagnosis ?? []) }}
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
                
                @if(method_exists($visitHistory, 'links') && $patient)
                <div class="mt-4 pt-4 border-t">
                    {{ $visitHistory->appends(['patient_id' => $patient->id])->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
        <p class="text-blue-700">Please select a patient to view history and add documentation.</p>
    </div>
    @endif
</div>
@endsection
