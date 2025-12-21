@extends('doctor.layouts.layout')

@section('title', 'Write Prescription - DDU Clinics')
@section('page-title', 'Write Prescription')
@section('page-subtitle', 'Prescribe medication to patients')

@section('styles')
<style>
    .medication-dropdown {
        scrollbar-width: thin;
        scrollbar-color: #059669 #f1f1f1;
    }

    .medication-dropdown::-webkit-scrollbar {
        width: 6px;
    }

    .medication-dropdown::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .medication-dropdown::-webkit-scrollbar-thumb {
        background: #059669;
        border-radius: 4px;
    }

    .medication-option:first-child {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .medication-option:last-child {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Create New Prescription</h2>

        <form action="{{ route('doctor.store-prescription') }}" method="POST" class="space-y-8">
            @csrf
            <!-- Patient Information -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-user-injured mr-2"></i> Patient Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Select Patient *</label>
                        <select name="patient_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" id="patientSelect" required>
                            <option value="">Select patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" data-dob="{{ $patient->date_of_birth }}" data-gender="{{ $patient->gender }}">
                                    {{ $patient->full_name }} ({{ $patient->card_number }})
                                </option>
                            @endforeach
                        </select>
                        @if($appointments->isNotEmpty())
                            <div class="mt-2">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Or Select from Today's Appointments</label>
                                <select name="appointment_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" id="appointmentSelect">
                                    <option value="">Select appointment</option>
                                    @foreach($appointments as $appointment)
                                        <option value="{{ $appointment->id }}" data-patient-id="{{ $appointment->patient_id }}" data-dob="{{ $appointment->patient->date_of_birth }}" data-gender="{{ $appointment->patient->gender }}">
                                            {{ $appointment->patient->full_name }} - {{ $appointment->appointment_time->format('h:i A') }} ({{ $appointment->reason ?? 'Consultation' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Age</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" id="patientAge" readonly>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" id="patientGender" readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Diagnosis</label>
                    <input type="text" name="diagnosis" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., Upper Respiratory Infection, Hypertension, etc.">
                </div>
            </div>

            <!-- Medication Section -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                        <i class="fas fa-pills mr-2"></i> Medications
                    </h3>
                    <button type="button" id="addMedication" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add Medication</span>
                    </button>
                </div>

                <!-- Medication Template (hidden) -->
                <div id="medicationTemplate" class="hidden">
                    <div class="medication-item border border-gray-300 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-medium text-gray-800">Medication #<span class="med-number">1</span></h4>
                            <button type="button" class="remove-medication text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Medication *</label>
                                <div class="relative medication-search-wrapper">
                                    <input type="hidden" name="medications[][medication_id]" class="medication-id-input" required>
                                    <input type="text"
                                           class="medication-search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary"
                                           placeholder="Type to search medication..."
                                           autocomplete="off">
                                    <div class="medication-dropdown absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                        @foreach($medications as $medication)
                                            @php
                                                $medDisplay = $medication->name;
                                                if ($medication->strength) {
                                                    $medDisplay .= ' ' . $medication->strength;
                                                }
                                                if ($medication->dosage_form) {
                                                    $medDisplay .= ' - ' . $medication->dosage_form;
                                                }
                                            @endphp
                                            <div class="medication-option px-4 py-2 hover:bg-ddu-primary hover:text-white cursor-pointer transition"
                                                 data-id="{{ $medication->id }}"
                                                 data-name="{{ $medDisplay }}">
                                                {{ $medDisplay }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="absolute right-3 top-2.5 pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Dosage *</label>
                                <input type="text" name="medications[][dosage]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., 1 tablet" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Frequency *</label>
                                <select name="medications[][frequency]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                                    <option value="">Select frequency</option>
                                    <option value="Once daily (OD)">Once daily (OD)</option>
                                    <option value="Twice daily (BD)">Twice daily (BD)</option>
                                    <option value="Three times daily (TDS)">Three times daily (TDS)</option>
                                    <option value="Four times daily (QID)">Four times daily (QID)</option>
                                    <option value="As needed (PRN)">As needed (PRN)</option>
                                    <option value="Every 6 hours">Every 6 hours</option>
                                    <option value="Every 8 hours">Every 8 hours</option>
                                    <option value="Every 12 hours">Every 12 hours</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Quantity *</label>
                                <input type="number" name="medications[][quantity]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., 10" min="1" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Duration (Days)</label>
                                <input type="number" name="medications[][duration_days]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., 5" min="1">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Instructions</label>
                                <textarea name="medications[][instructions]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="2" placeholder="Take after meals, avoid alcohol, etc."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medications Container -->
                <div id="medicationsContainer">
                    <!-- First medication will be added here by JavaScript -->
                </div>
            </div>

            <!-- Additional Instructions -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-file-medical-alt mr-2"></i> Additional Instructions
                </h3>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Doctor's Notes</label>
                    <textarea name="notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="4" placeholder="Additional advice, follow-up instructions, lifestyle recommendations..."></textarea>
                </div>
            </div>

      <div class="flex justify-end space-x-4 pt-6 border-t">
    <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Save Draft
    </button>
    <button type="button" class="px-6 py-3 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
        Preview
    </button>
    <button id="submitBtn" type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
        <i class="fas fa-paper-plane"></i>
        <span>Send to Pharmacy</span>
    </button>
</div>
        </form>
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-2 mt-1"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Prescriptions -->
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Recent Prescriptions</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Prescription ID</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Patient</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Medications</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Date</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Pharmacy</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Status</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPrescriptions as $prescription)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                <span class="font-mono text-gray-800">{{ $prescription->prescription_number }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full {{ $prescription->patient->gender === 'Female' ? 'bg-pink-100' : 'bg-blue-100' }} flex items-center justify-center mr-3">
                                        <i class="fas fa-user {{ $prescription->patient->gender === 'Female' ? 'text-pink-600' : 'text-blue-600' }} text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $prescription->patient->full_name }}</div>
                                        <div class="text-gray-600 text-sm">{{ $prescription->diagnosis ?? 'No diagnosis' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($prescription->items->take(3) as $item)
                                        <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">
                                            {{ $item->medication->name }}
                                        </span>
                                    @endforeach
                                    @if($prescription->items->count() > 3)
                                        <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs">
                                            +{{ $prescription->items->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                {{ $prescription->prescription_date->format('M d, Y') }}
                                <div class="text-xs text-gray-500">{{ $prescription->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-600">DDU Pharmacy</span>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $statusClass = match($prescription->status) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'dispensed' => 'bg-blue-100 text-blue-800',
                                        'partially_dispensed' => 'bg-yellow-100 text-yellow-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $prescription->status)) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Copy">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                                No recent prescriptions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')


<script>

    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="store-prescription"]');
    const submitBtn = document.getElementById('submitBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            let allMedicationsSelected = true;

            document.querySelectorAll('.medication-item').forEach((item, index) => {
                const hiddenInput = item.querySelector('.medication-id-input');
                if (!hiddenInput || !hiddenInput.value) {
                    allMedicationsSelected = false;
                    const searchInput = item.querySelector('.medication-search-input');
                    if (searchInput) searchInput.classList.add('border-red-500');
                }
            });

            if (!allMedicationsSelected) {
                e.preventDefault();
                alert('Please select all medications from the dropdown before submitting.');
                return false;
            }

            if (!form.checkValidity()) {
                e.preventDefault();
                form.reportValidity();
                return false;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Sending to Pharmacy...</span>';
            }

            // Let Laravel handle submission normally
        });
    }
});


    document.addEventListener('DOMContentLoaded', function() {
        let medicationCount = 0;

        // Add first medication
        addMedication();

        // Add medication button click
        document.getElementById('addMedication').addEventListener('click', function() {
            addMedication();
        });

        // Patient data from options
        const patientDataMap = {};
        document.querySelectorAll('#patientSelect option').forEach(option => {
            if (option.value && option.dataset.dob) {
                patientDataMap[option.value] = {
                    dob: option.dataset.dob,
                    gender: option.dataset.gender || ''
                };
            }
        });

        // Patient selection change
        document.getElementById('patientSelect').addEventListener('change', function() {
            updatePatientInfo(this.value);
        });

        // Appointment selection change
        const appointmentSelect = document.getElementById('appointmentSelect');
        if (appointmentSelect) {
            appointmentSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    // Set patient select to match appointment
                    document.getElementById('patientSelect').value = selectedOption.dataset.patientId;
                    updatePatientInfo(selectedOption.dataset.patientId, {
                        dob: selectedOption.dataset.dob,
                        gender: selectedOption.dataset.gender
                    });
                }
            });
        }

        function updatePatientInfo(patientId, data = null) {
            const patientAge = document.getElementById('patientAge');
            const patientGender = document.getElementById('patientGender');

            let patientInfo = data;
            if (!patientInfo && patientId) {
                patientInfo = patientDataMap[patientId];
            }

            if (patientInfo && patientInfo.dob) {
                // Calculate age from date of birth
                const dob = new Date(patientInfo.dob);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                patientAge.value = age + ' years';
                patientGender.value = patientInfo.gender ? patientInfo.gender.charAt(0).toUpperCase() + patientInfo.gender.slice(1) : '';
            } else {
                patientAge.value = '';
                patientGender.value = '';
            }
        }

        function addMedication() {
            medicationCount++;
            const template = document.getElementById('medicationTemplate').cloneNode(true);
            template.classList.remove('hidden');
            template.id = '';

            // Update medication number
            const medNumber = template.querySelector('.med-number');
            if (medNumber) {
                medNumber.textContent = medicationCount;
            }

            // Add remove functionality first
            const removeBtn = template.querySelector('.remove-medication');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    if (document.querySelectorAll('.medication-item').length > 1) {
                        template.remove();
                        medicationCount--; // Decrement counter
                    } else {
                        alert('At least one medication is required.');
                    }
                });
            }

            // Add to container BEFORE initializing search (so DOM is ready)
            document.getElementById('medicationsContainer').appendChild(template);

            // Initialize searchable dropdown for the new medication AFTER it's added to DOM
            setTimeout(() => {
                initMedicationSearch(template);
            }, 50);

            // Animate the new medication
            template.style.opacity = '0';
            template.style.transform = 'translateY(20px)';

            setTimeout(() => {
                template.style.transition = 'all 0.3s ease';
                template.style.opacity = '1';
                template.style.transform = 'translateY(0)';
            }, 10);
        }

        // Initialize searchable medication dropdown
        function initMedicationSearch(container) {
            const wrapper = container.querySelector('.medication-search-wrapper');
            if (!wrapper) return;

            const searchInput = wrapper.querySelector('.medication-search-input');
            const hiddenInput = wrapper.querySelector('.medication-id-input');
            const dropdown = wrapper.querySelector('.medication-dropdown');
            const options = wrapper.querySelectorAll('.medication-option');
            const chevron = wrapper.querySelector('.fa-chevron-down');

            if (!searchInput || !hiddenInput || !dropdown) return;

            // Show dropdown on focus
            searchInput.addEventListener('focus', function() {
                dropdown.classList.remove('hidden');
                chevron.classList.remove('fa-chevron-down');
                chevron.classList.add('fa-chevron-up');
            });

            // Filter options on input
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let hasVisibleOptions = false;

                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        option.style.display = 'block';
                        hasVisibleOptions = true;
                    } else {
                        option.style.display = 'none';
                    }
                });

                dropdown.classList.toggle('hidden', !hasVisibleOptions);
            });

            // Handle option selection
            options.forEach(option => {
                option.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    if (!id || !name) {
                        console.error('Medication option missing data:', this);
                        return;
                    }

                    if (hiddenInput) {
                        hiddenInput.value = id;
                        hiddenInput.dataset.selectedName = name;
                        // Remove any validation errors
                        hiddenInput.setCustomValidity('');
                        // Trigger events to ensure form validation works
                        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                        hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));

                        // Verify the value was set
                        if (hiddenInput.value !== id) {
                            console.error('Failed to set hidden input value');
                        }
                    } else {
                        console.error('Hidden input not found in medication wrapper');
                    }

                    if (searchInput) {
                        searchInput.value = name;
                        searchInput.setCustomValidity('');
                        searchInput.dataset.selectedId = id;
                    }

                    dropdown.classList.add('hidden');
                    if (chevron) {
                        chevron.classList.remove('fa-chevron-up');
                        chevron.classList.add('fa-chevron-down');
                    }

                    console.log('Medication selected:', { id, name, hiddenInputValue: hiddenInput?.value });
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    chevron.classList.remove('fa-chevron-up');
                    chevron.classList.add('fa-chevron-down');
                }
            });

            // Handle keyboard navigation
            searchInput.addEventListener('keydown', function(e) {
                const visibleOptions = Array.from(options).filter(opt => opt.style.display !== 'none');

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const currentIndex = visibleOptions.findIndex(opt => opt.classList.contains('bg-ddu-primary'));
                    const nextIndex = currentIndex < visibleOptions.length - 1 ? currentIndex + 1 : 0;
                    visibleOptions.forEach(opt => opt.classList.remove('bg-ddu-primary', 'text-white'));
                    if (visibleOptions[nextIndex]) {
                        visibleOptions[nextIndex].classList.add('bg-ddu-primary', 'text-white');
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const currentIndex = visibleOptions.findIndex(opt => opt.classList.contains('bg-ddu-primary'));
                    const prevIndex = currentIndex > 0 ? currentIndex - 1 : visibleOptions.length - 1;
                    visibleOptions.forEach(opt => opt.classList.remove('bg-ddu-primary', 'text-white'));
                    if (visibleOptions[prevIndex]) {
                        visibleOptions[prevIndex].classList.add('bg-ddu-primary', 'text-white');
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    const selected = visibleOptions.find(opt => opt.classList.contains('bg-ddu-primary'));
                    if (selected) {
                        selected.click();
                    }
                } else if (e.key === 'Escape') {
                    dropdown.classList.add('hidden');
                    chevron.classList.remove('fa-chevron-up');
                    chevron.classList.add('fa-chevron-down');
                }
            });

            // Validate on form submit
            hiddenInput.addEventListener('invalid', function() {
                if (!this.value) {
                    searchInput.setCustomValidity('Please select a medication');
                }
            });
        }

        // Initialize searchable dropdowns for existing medication items after first medication is added
        setTimeout(() => {
            document.querySelectorAll('.medication-item').forEach(item => {
                initMedicationSearch(item);
            });
        }, 100);

        // Form submission - only show loading state, let Laravel handle validation
        const form = document.querySelector('form[action*="store-prescription"]');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form submit event triggered');

                // Verify all medication hidden inputs have values
                const medicationItems = document.querySelectorAll('.medication-item');
                let allMedicationsSelected = true;

                medicationItems.forEach((item, index) => {
                    const hiddenInput = item.querySelector('.medication-id-input');
                    if (!hiddenInput || !hiddenInput.value) {
                        allMedicationsSelected = false;
                        console.error(`Medication ${index + 1} not selected`);
                        const searchInput = item.querySelector('.medication-search-input');
                        if (searchInput) {
                            searchInput.classList.add('border-red-500');
                        }
                    }
                });

                if (!allMedicationsSelected) {
                    e.preventDefault();
                    alert('Please select all medications before submitting. Click on a medication from the dropdown list.');
                    return false;
                }

                // Check if form is valid (basic HTML5 validation)
                if (!form.checkValidity()) {
                    console.log('Form HTML5 validation failed');
                    form.reportValidity();
                    e.preventDefault();
                    return false;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Sending to Pharmacy...</span>';
                }

                console.log('Form is valid, submitting to Laravel...');
                // Let the form submit normally to Laravel
                return true;
            });
        }
    });
</script>
@endsection
