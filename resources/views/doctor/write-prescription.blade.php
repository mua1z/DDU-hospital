@extends('doctor.layouts.layout')

@section('title', 'Write Prescription - DDU Clinics')
@section('page-title', 'Write Prescription')
@section('page-subtitle', 'Create and manage patient prescriptions')

@section('styles')
<style>
    .prescription-form {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .medicine-row {
        transition: all 0.3s ease;
    }

    .medicine-row:hover {
        background-color: #f0fdf4;
    }

    .search-results {
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 50;
    }

    .prescription-template {
        background: linear-gradient(135deg, #f8fafc 0%, #f0fdf4 100%);
        border: 2px dashed #10b981;
    }

    .print-only {
        display: none;
    }

    @media print {
        .print-only {
            display: block;
        }

        .no-print {
            display: none !important;
        }

        body {
            background: white !important;
        }

        .prescription-template {
            border: none;
            box-shadow: none;
        }
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 no-print">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Write New Prescription</h2>
            <p class="text-gray-600">Create prescriptions for your patients</p>
        </div>
        <div class="flex items-center space-x-3">
            <button id="saveDraftBtn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center space-x-2">
                <i class="fas fa-save"></i>
                <span>Save Draft</span>
            </button>
            <button id="printPrescriptionBtn" class="px-4 py-2 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                <i class="fas fa-print"></i>
                <span>Print Prescription</span>
            </button>
        </div>
    </div>

    <!-- Error/Success Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg animate-slide-up">
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg animate-slide-up">
        <div class="flex items-center space-x-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>Please fix the following errors:</span>
        </div>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Prescription Form -->
    <form id="prescriptionForm" method="POST" action="{{ route('doctor.store-prescription') }}" class="bg-white rounded-xl shadow-lg overflow-hidden">
        @csrf

        <!-- Patient Information Section -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Patient Search/Select -->
                <div class="col-span-2 relative">
                    <label for="patientSearch" class="block text-sm font-medium text-gray-700 mb-1">
                        Select Patient <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                               id="patientSearch"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                               placeholder="Search by name, ID, or phone..."
                               autocomplete="off">
                        <div id="patientResults" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg search-results"></div>
                    </div>
                    <input type="hidden" name="patient_id" id="patientId">
                </div>

                <!-- Appointment Select -->
                <div>
                    <label for="appointmentId" class="block text-sm font-medium text-gray-700 mb-1">
                        Appointment
                    </label>
                    <select id="appointmentId" name="appointment_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent">
                        <option value="">Select Appointment</option>
                        @foreach($appointments ?? [] as $appointment)
                        <option value="{{ $appointment->id }}">{{ $appointment->patient->name ?? 'Unknown' }} - {{ $appointment->date }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="prescriptionDate" class="block text-sm font-medium text-gray-700 mb-1">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="prescriptionDate"
                           name="date"
                           value="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent">
                </div>
            </div>

            <!-- Selected Patient Info -->
            <div id="patientInfo" class="hidden mt-4 p-4 bg-green-50 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Patient Name</p>
                        <p id="patientName" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Age & Gender</p>
                        <p id="patientAgeGender" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact</p>
                        <p id="patientContact" class="font-semibold text-gray-800"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagnosis Section -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Diagnosis & Notes</h3>
            <div class="space-y-4">
                <!-- Diagnosis -->
                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">
                        Diagnosis <span class="text-red-500">*</span>
                    </label>
                    <textarea id="diagnosis"
                              name="diagnosis"
                              rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                              placeholder="Enter primary diagnosis..."></textarea>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Additional Notes
                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                              placeholder="Any additional notes or instructions..."></textarea>
                </div>

                <!-- Symptoms -->
                <div>
                    <label for="symptoms" class="block text-sm font-medium text-gray-700 mb-1">
                        Symptoms
                    </label>
                    <div class="flex flex-wrap gap-2 mb-2">
                        <span class="symptom-tag px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Fever</span>
                        <span class="symptom-tag px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Cough</span>
                        <span class="symptom-tag px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Headache</span>
                        <span class="symptom-tag px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Fatigue</span>
                    </div>
                    <input type="text"
                           id="symptoms"
                           name="symptoms"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                           placeholder="Type symptoms and press Enter...">
                </div>
            </div>
        </div>

        <!-- Medicines Section -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Medicines</h3>
                <button type="button"
                        id="addMedicineBtn"
                        class="px-4 py-2 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Medicine</span>
                </button>
            </div>

            <!-- Medicines Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Medicine</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Dosage</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Frequency</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Duration</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Quantity</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Instructions</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody id="medicinesTable">
                        <!-- Medicines will be added here dynamically -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="noMedicinesMessage" class="text-center py-8 text-gray-500">
                <i class="fas fa-pills text-4xl mb-3"></i>
                <p>No medicines added yet. Click "Add Medicine" to start.</p>
            </div>
        </div>

        <!-- Additional Instructions -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Instructions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Diet & Lifestyle -->
                <div>
                    <label for="dietInstructions" class="block text-sm font-medium text-gray-700 mb-1">
                        Diet & Lifestyle
                    </label>
                    <textarea id="dietInstructions"
                              name="diet_instructions"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                              placeholder="Dietary restrictions, exercise, etc..."></textarea>
                </div>

                <!-- Follow-up -->
                <div>
                    <label for="followUp" class="block text-sm font-medium text-gray-700 mb-1">
                        Follow-up Instructions
                    </label>
                    <textarea id="followUp"
                              name="follow_up"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                              placeholder="Follow-up schedule, next visit, etc..."></textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-6 bg-gray-50 no-print">
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                <button type="reset" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Clear Form
                </button>
                <button type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition font-medium">
                    Save & Complete Prescription
                </button>
            </div>
        </div>
    </form>

    <!-- Prescription Preview (Print Template) -->
    <div id="prescriptionPreview" class="hidden">
        <div class="prescription-template p-8 rounded-xl shadow-lg mt-6">
            <!-- Clinic Header -->
            <div class="text-center mb-8 print-only">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-ddu-primary flex items-center justify-center">
                        <i class="fas fa-stethoscope text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-ddu-primary">DDU Clinics</h1>
                        <p class="text-gray-600">Quality Healthcare Services</p>
                    </div>
                </div>
                <div class="border-t border-b border-gray-300 py-2">
                    <p class="text-gray-700">123 Medical Street, Healthcare City | Phone: (123) 456-7890</p>
                </div>
            </div>

            <!-- Prescription Title -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-ddu-primary mb-2">MEDICAL PRESCRIPTION</h2>
                <div class="flex justify-between items-center">
                    <div class="text-left">
                        <p class="text-gray-600">Date: <span id="printDate" class="font-semibold">{{ date('F d, Y') }}</span></p>
                        <p class="text-gray-600">Prescription ID: <span class="font-semibold">PR-{{ strtoupper(uniqid()) }}</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">Doctor: <span class="font-semibold">Dr. Ahmed Ali</span></p>
                        <p class="text-gray-600">License: <span class="font-semibold">MED-123456</span></p>
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="mb-8 p-4 bg-green-50 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Patient Information</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p id="printPatientName" class="font-semibold text-gray-800">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Age & Gender</p>
                        <p id="printPatientAgeGender" class="font-semibold text-gray-800">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact</p>
                        <p id="printPatientContact" class="font-semibold text-gray-800">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date</p>
                        <p id="printFullDate" class="font-semibold text-gray-800">{{ date('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Diagnosis</h3>
                <div class="p-3 border border-gray-200 rounded">
                    <p id="printDiagnosis" class="text-gray-700">-</p>
                </div>
            </div>

            <!-- Medicines -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Prescribed Medicines</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Medicine</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Dosage</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Frequency</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Duration</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Qty</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Instructions</th>
                            </tr>
                        </thead>
                        <tbody id="printMedicinesTable">
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-4 text-center text-gray-500">No medicines prescribed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Instructions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Additional Instructions</h3>
                    <div class="p-3 border border-gray-200 rounded">
                        <p id="printInstructions" class="text-gray-700">-</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Follow-up</h3>
                    <div class="p-3 border border-gray-200 rounded">
                        <p id="printFollowUp" class="text-gray-700">-</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-300 pt-6 mt-8">
                <div class="flex justify-between">
                    <div class="text-center">
                        <div class="mb-2">
                            <p class="font-semibold text-gray-800">_________________________</p>
                        </div>
                        <p class="text-gray-600">Doctor's Signature</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-2">
                            <p class="font-semibold text-gray-800">_________________________</p>
                        </div>
                        <p class="text-gray-600">Patient's Signature</p>
                    </div>
                </div>
                <div class="text-center mt-8 pt-4 border-t border-gray-300">
                    <p class="text-sm text-gray-500">This is a computer-generated prescription. No physical signature required.</p>
                    <p class="text-sm text-gray-500">Generated on {{ date('F d, Y \a\t h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let medicineCounter = 0;
        const medicinesTable = document.getElementById('medicinesTable');
        const noMedicinesMessage = document.getElementById('noMedicinesMessage');

        // Sample medicines for autocomplete
        const medicinesList = [
            { name: 'Paracetamol 500mg', type: 'Tablet' },
            { name: 'Amoxicillin 250mg', type: 'Capsule' },
            { name: 'Ibuprofen 400mg', type: 'Tablet' },
            { name: 'Cetirizine 10mg', type: 'Tablet' },
            { name: 'Omeprazole 20mg', type: 'Capsule' },
            { name: 'Metformin 500mg', type: 'Tablet' },
            { name: 'Atorvastatin 10mg', type: 'Tablet' },
            { name: 'Salbutamol Inhaler', type: 'Inhaler' },
            { name: 'Diazepam 5mg', type: 'Tablet' },
            { name: 'Ciprofloxacin 500mg', type: 'Tablet' }
        ];

        // Patient search functionality
        const patientSearch = document.getElementById('patientSearch');
        const patientResults = document.getElementById('patientResults');

        // Sample patients data (replace with API call in real implementation)
        const patients = [
            { id: 1, name: 'John Smith', age: 45, gender: 'Male', phone: '+1 234-567-8901' },
            { id: 2, name: 'Emma Wilson', age: 32, gender: 'Female', phone: '+1 234-567-8902' },
            { id: 3, name: 'Robert Johnson', age: 58, gender: 'Male', phone: '+1 234-567-8903' },
            { id: 4, name: 'Sarah Davis', age: 28, gender: 'Female', phone: '+1 234-567-8904' },
            { id: 5, name: 'Michael Brown', age: 65, gender: 'Male', phone: '+1 234-567-8905' }
        ];

        // Patient search handler
        patientSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            patientResults.innerHTML = '';

            if (query.length < 2) {
                patientResults.classList.add('hidden');
                return;
            }

            const filteredPatients = patients.filter(patient =>
                patient.name.toLowerCase().includes(query) ||
                patient.phone.includes(query)
            );

            if (filteredPatients.length > 0) {
                filteredPatients.forEach(patient => {
                    const div = document.createElement('div');
                    div.className = 'p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100';
                    div.innerHTML = `
                        <p class="font-medium text-gray-800">${patient.name}</p>
                        <p class="text-sm text-gray-600">${patient.age} years, ${patient.gender} | ${patient.phone}</p>
                    `;
                    div.addEventListener('click', function() {
                        selectPatient(patient);
                    });
                    patientResults.appendChild(div);
                });
                patientResults.classList.remove('hidden');
            } else {
                const div = document.createElement('div');
                div.className = 'p-3 text-gray-500 text-center';
                div.textContent = 'No patients found';
                patientResults.appendChild(div);
                patientResults.classList.remove('hidden');
            }
        });

        // Close patient results when clicking outside
        document.addEventListener('click', function(e) {
            if (!patientSearch.contains(e.target) && !patientResults.contains(e.target)) {
                patientResults.classList.add('hidden');
            }
        });

        // Select patient function
        function selectPatient(patient) {
            document.getElementById('patientId').value = patient.id;
            patientSearch.value = patient.name;

            // Show patient info
            const patientInfo = document.getElementById('patientInfo');
            document.getElementById('patientName').textContent = patient.name;
            document.getElementById('patientAgeGender').textContent = `${patient.age} years, ${patient.gender}`;
            document.getElementById('patientContact').textContent = patient.phone;
            patientInfo.classList.remove('hidden');

            // Update print preview
            document.getElementById('printPatientName').textContent = patient.name;
            document.getElementById('printPatientAgeGender').textContent = `${patient.age} years, ${patient.gender}`;
            document.getElementById('printPatientContact').textContent = patient.phone;

            patientResults.classList.add('hidden');
        }

        // Add medicine row
        document.getElementById('addMedicineBtn').addEventListener('click', addMedicineRow);

        // Initial medicine row
        addMedicineRow();

        function addMedicineRow() {
            medicineCounter++;
            noMedicinesMessage.style.display = 'none';

            const row = document.createElement('tr');
            row.className = 'medicine-row';
            row.innerHTML = `
                <td class="px-4 py-3">
                    <div class="relative">
                        <input type="text"
                               name="medicines[${medicineCounter}][name]"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-ddu-primary focus:border-transparent medicine-name"
                               placeholder="Medicine name"
                               required>
                        <div class="medicine-suggestions hidden absolute z-40 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-40 overflow-y-auto"></div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <select name="medicines[${medicineCounter}][dosage]" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-ddu-primary focus:border-transparent" required>
                        <option value="">Select</option>
                        <option value="1 tablet">1 tablet</option>
                        <option value="2 tablets">2 tablets</option>
                        <option value="1 capsule">1 capsule</option>
                        <option value="2 capsules">2 capsules</option>
                        <option value="5ml">5ml</option>
                        <option value="10ml">10ml</option>
                        <option value="1 puff">1 puff</option>
                        <option value="2 puffs">2 puffs</option>
                        <option value="As directed">As directed</option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    <select name="medicines[${medicineCounter}][frequency]" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-ddu-primary focus:border-transparent" required>
                        <option value="">Select</option>
                        <option value="Once daily">Once daily</option>
                        <option value="Twice daily">Twice daily</option>
                        <option value="Three times daily">Three times daily</option>
                        <option value="Four times daily">Four times daily</option>
                        <option value="Every 6 hours">Every 6 hours</option>
                        <option value="Every 8 hours">Every 8 hours</option>
                        <option value="Every 12 hours">Every 12 hours</option>
                        <option value="As needed">As needed</option>
                        <option value="At bedtime">At bedtime</option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    <select name="medicines[${medicineCounter}][duration]" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-ddu-primary focus:border-transparent" required>
                        <option value="">Select</option>
                        <option value="1 day">1 day</option>
                        <option value="3 days">3 days</option>
                        <option value="5 days">5 days</option>
                        <option value="7 days">7 days</option>
                        <option value="10 days">10 days</option>
                        <option value="14 days">14 days</option>
                        <option value="30 days">30 days</option>
                        <option value="Until finished">Until finished</option>
                        <option value="As needed">As needed</option>
                    </select>
                </td>
                <td class="px-4 py-3">
                    <input type="number"
                           name="medicines[${medicineCounter}][quantity]"
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                           placeholder="Qty"
                           value="1"
                           min="1"
                           required>
                </td>
                <td class="px-4 py-3">
                    <input type="text"
                           name="medicines[${medicineCounter}][instructions]"
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-ddu-primary focus:border-transparent"
                           placeholder="e.g., After meals">
                </td>
                <td class="px-4 py-3">
                    <button type="button" class="remove-medicine-btn p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            medicinesTable.appendChild(row);

            // Add autocomplete for medicine name
            const medicineInput = row.querySelector('.medicine-name');
            const suggestionsDiv = row.querySelector('.medicine-suggestions');

            medicineInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                suggestionsDiv.innerHTML = '';

                if (query.length < 2) {
                    suggestionsDiv.classList.add('hidden');
                    return;
                }

                const filteredMedicines = medicinesList.filter(medicine =>
                    medicine.name.toLowerCase().includes(query)
                );

                if (filteredMedicines.length > 0) {
                    filteredMedicines.forEach(medicine => {
                        const div = document.createElement('div');
                        div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                        div.textContent = `${medicine.name} (${medicine.type})`;
                        div.addEventListener('click', function() {
                            medicineInput.value = medicine.name;
                            suggestionsDiv.classList.add('hidden');
                        });
                        suggestionsDiv.appendChild(div);
                    });
                    suggestionsDiv.classList.remove('hidden');
                }
            });

            // Close suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!medicineInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                    suggestionsDiv.classList.add('hidden');
                }
            });

            // Remove medicine row
            row.querySelector('.remove-medicine-btn').addEventListener('click', function() {
                row.remove();
                if (medicinesTable.children.length === 0) {
                    noMedicinesMessage.style.display = 'block';
                }
            });
        }

        // Symptoms tag functionality
        const symptomsInput = document.getElementById('symptoms');
        symptomsInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const symptom = this.value.trim();
                if (symptom) {
                    addSymptomTag(symptom);
                    this.value = '';
                }
            }
        });

        function addSymptomTag(symptom) {
            const tag = document.createElement('span');
            tag.className = 'symptom-tag px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm cursor-pointer';
            tag.textContent = symptom;
            tag.innerHTML += ' <i class="fas fa-times ml-1 text-xs"></i>';

            tag.querySelector('i').addEventListener('click', function() {
                tag.remove();
            });

            symptomsInput.parentElement.querySelector('.flex').appendChild(tag);
        }

        // Save draft functionality
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            // In a real app, you would save to localStorage or send to server
            alert('Draft saved successfully!');
        });

        // Print prescription functionality
        document.getElementById('printPrescriptionBtn').addEventListener('click', function() {
            // Update print preview with current form data
            updatePrintPreview();

            // Show the preview
            const preview = document.getElementById('prescriptionPreview');
            preview.classList.remove('hidden');

            // Wait a moment for DOM update, then print
            setTimeout(() => {
                window.print();
                preview.classList.add('hidden');
            }, 100);
        });

        function updatePrintPreview() {
            // Update date
            const dateInput = document.getElementById('prescriptionDate');
            if (dateInput.value) {
                const date = new Date(dateInput.value);
                document.getElementById('printDate').textContent = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                document.getElementById('printFullDate').textContent = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            // Update diagnosis
            const diagnosis = document.getElementById('diagnosis').value || '-';
            document.getElementById('printDiagnosis').textContent = diagnosis;

            // Update instructions
            const instructions = document.getElementById('dietInstructions').value || '-';
            document.getElementById('printInstructions').textContent = instructions;

            // Update follow-up
            const followUp = document.getElementById('followUp').value || '-';
            document.getElementById('printFollowUp').textContent = followUp;

            // Update medicines table for print
            const printTable = document.getElementById('printMedicinesTable');
            printTable.innerHTML = '';

            const medicineRows = document.querySelectorAll('.medicine-row');
            if (medicineRows.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="6" class="border border-gray-300 px-4 py-4 text-center text-gray-500">
                        No medicines prescribed
                    </td>
                `;
                printTable.appendChild(row);
            } else {
                medicineRows.forEach(row => {
                    const name = row.querySelector('input[name*="[name]"]').value;
                    const dosage = row.querySelector('select[name*="[dosage]"]').value;
                    const frequency = row.querySelector('select[name*="[frequency]"]').value;
                    const duration = row.querySelector('select[name*="[duration]"]').value;
                    const quantity = row.querySelector('input[name*="[quantity]"]').value;
                    const instructions = row.querySelector('input[name*="[instructions]"]').value;

                    const printRow = document.createElement('tr');
                    printRow.innerHTML = `
                        <td class="border border-gray-300 px-4 py-2">${name || '-'}</td>
                        <td class="border border-gray-300 px-4 py-2">${dosage || '-'}</td>
                        <td class="border border-gray-300 px-4 py-2">${frequency || '-'}</td>
                        <td class="border border-gray-300 px-4 py-2">${duration || '-'}</td>
                        <td class="border border-gray-300 px-4 py-2">${quantity || '-'}</td>
                        <td class="border border-gray-300 px-4 py-2">${instructions || '-'}</td>
                    `;
                    printTable.appendChild(printRow);
                });
            }
        }

        // Form submission
        document.getElementById('prescriptionForm').addEventListener('submit', function(e) {
            // Client-side validation
            const patientId = document.getElementById('patientId').value;
            const diagnosis = document.getElementById('diagnosis').value;

            if (!patientId) {
                e.preventDefault();
                alert('Please select a patient');
                patientSearch.focus();
                return;
            }

            if (!diagnosis.trim()) {
                e.preventDefault();
                alert('Please enter a diagnosis');
                document.getElementById('diagnosis').focus();
                return;
            }

            // Check if at least one medicine is added
            const medicineRows = document.querySelectorAll('.medicine-row');
            if (medicineRows.length === 0) {
                const confirmNoMeds = confirm('No medicines have been added. Do you want to continue without prescribing any medicines?');
                if (!confirmNoMeds) {
                    e.preventDefault();
                    return;
                }
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
            submitBtn.disabled = true;
        });

        // Initialize date field with today's date
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('prescriptionDate').value = today;
    });
</script>
@endsection
