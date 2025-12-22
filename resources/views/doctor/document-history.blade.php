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
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" id="patientSelect">
                    <option value="">Search by name or ID</option>
                    <option value="1" selected>Salem Asfaw (STU0150)</option>
                    <option value="2">Marta Solomon (STU0224)</option>
                    <option value="3">Mohammed Dawud (STU0187)</option>
                    <option value="4">Kebede Abebe (STU0225)</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Patient ID</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="STU0150" readonly>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Last Visit</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" value="Today, 08:30 AM" readonly>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Medical History Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Current Visit Documentation</h2>

                <form action="#" method="POST" class="space-y-6">
                    <!-- Chief Complaint -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-comment-medical mr-2"></i> Chief Complaint
                        </h3>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Presenting Symptoms *</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Describe the patient's main symptoms, duration, and severity..." required>Fever (38.5°C), dry cough for 3 days, mild headache, fatigue. Symptoms started gradually.</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Onset</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" value="3 days ago" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Severity</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                                    <option value="mild">Mild</option>
                                    <option value="moderate" selected>Moderate</option>
                                    <option value="severe">Severe</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- History of Present Illness -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-history mr-2"></i> History of Present Illness
                        </h3>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Detailed History</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="4" placeholder="Chronological account of symptoms, progression, aggravating/alleviating factors...">Patient reports fever starting 3 days ago with dry cough. No chest pain or shortness of breath. Appetite decreased but drinking adequate fluids. No recent travel or sick contacts.</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Aggravating Factors</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., cold air, physical activity">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Alleviating Factors</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., rest, medication">
                            </div>
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
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded" value="38.5°C">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">BP</div>
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded" value="120/80">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">Pulse</div>
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded" value="88 bpm">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">Resp. Rate</div>
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded" value="18/min">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">BMI</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <div class="text-xs text-gray-600">Height</div>
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded" value="175 cm">
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-600">Weight</div>
                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded" value="68 kg">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Examination Findings</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="General appearance, system examination findings...">Alert and oriented. Mild pharyngeal erythema. Clear lung sounds bilaterally. No lymphadenopathy. Abdomen soft and non-tender.</textarea>
                        </div>
                    </div>

                    <!-- Assessment & Plan -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                            <i class="fas fa-diagnoses mr-2"></i> Assessment & Plan
                        </h3>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Diagnosis *</label>
                            <div class="space-y-2">
                                @foreach(['Upper Respiratory Infection', 'Viral Pharyngitis', 'Acute Bronchitis', 'Other'] as $diagnosis)
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" class="rounded text-blue-600" {{ $diagnosis === 'Upper Respiratory Infection' ? 'checked' : '' }}>
                                    <span class="text-gray-700">{{ $diagnosis }}</span>
                                </label>
                                @endforeach
                            </div>
                            <input type="text" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Other diagnosis...">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Treatment Plan</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Medications prescribed, procedures, referrals, follow-up...">1. Symptomatic treatment for fever and cough
2. Prescribed Amoxicillin 500mg TDS for 5 days
3. Advised rest and adequate hydration
4. Follow-up in 3 days if symptoms persist</textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Save as Draft
                        </button>
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
                            <h3 class="font-bold text-gray-800 text-lg">Salem Asfaw</h3>
                            <p class="text-gray-600">STU0150 • 21 years • Male</p>
                            <p class="text-gray-600 text-sm">Computer Science, 3rd Year</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-4 border-t">
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-800">5</div>
                            <div class="text-gray-600 text-sm">Total Visits</div>
                        </div>

                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-800">2</div>
                            <div class="text-gray-600 text-sm">Active Issues</div>
                        </div>
                    </div>

                    <div class="pt-4 border-t">
                        <h4 class="font-medium text-gray-800 mb-2">Known Allergies</h4>
                        <div class="flex flex-wrap gap-1">
                            <span class="bg-red-100 text-red-800 py-1 px-2 rounded text-xs">Penicillin</span>
                            <span class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded text-xs">Sulfa Drugs</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t">
                        <h4 class="font-medium text-gray-800 mb-2">Chronic Conditions</h4>
                        <div class="space-y-1">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Asthma (Controlled)</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-times-circle text-gray-400 mr-2"></i>
                                <span>No Diabetes</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-times-circle text-gray-400 mr-2"></i>
                                <span>No Hypertension</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visit History -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Visit History</h2>

                <div class="space-y-4">
                    @forelse($visitHistory as $visit)
                    <div class="border-l-4 {{ $visit['borderColor'] }} pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium text-gray-800">{{ $visit['date'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $visit['diagnosis'] }}</div>
                            </div>
                            <span class="text-xs {{ $visit['statusColor'] }} font-medium">{{ $visit['status'] }}</span>
                        </div>
                        <div class="text-gray-600 text-sm mt-1">{{ $visit['doctor'] }}</div>
                        <div class="mt-2">
                            @foreach($visit['treatments'] as $treatment)
                            <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                {{ $treatment }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-gray-500 text-sm py-4">No visit history yet.</div>
                    @endforelse

                    <a href="#" class="block text-center text-ddu-primary hover:underline pt-4 border-t">
                        View Complete History →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
