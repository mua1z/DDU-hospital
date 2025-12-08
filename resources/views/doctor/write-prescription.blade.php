@extends('doctor.layouts.layout')

@section('title', 'Write Prescription - DDU Clinics')
@section('page-title', 'Write Prescription')
@section('page-subtitle', 'Prescribe medication to patients')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Create New Prescription</h2>
        
        <form action="#" method="POST" class="space-y-8">
            <!-- Patient Information -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-user-injured mr-2"></i> Patient Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Select Patient *</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" id="patientSelect">
                            <option value="">Select patient</option>
                            <option value="1">Salem Asfaw (STU0150) - Fever & Cough</option>
                            <option value="2">Marta Solomon (STU0224) - Abdominal Pain</option>
                            <option value="3">Mohammed Dawud (STU0187) - Headache</option>
                            <option value="4">Kebede Abebe (STU0225) - Allergy</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Age</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50" id="patientAge" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Weight (kg)</label>
                        <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., 65">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Diagnosis *</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., Upper Respiratory Infection, Hypertension, etc." required>
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
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                                    <option value="">Select medication</option>
                                    <option value="paracetamol">Paracetamol 500mg</option>
                                    <option value="amoxicillin">Amoxicillin 250mg</option>
                                    <option value="cetirizine">Cetirizine 10mg</option>
                                    <option value="omeprazole">Omeprazole 20mg</option>
                                    <option value="metformin">Metformin 500mg</option>
                                    <option value="losartan">Losartan 50mg</option>
                                    <option value="other">Other (Specify)</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Dosage *</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., 1 tablet" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Frequency *</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                                    <option value="">Select frequency</option>
                                    <option value="od">Once daily (OD)</option>
                                    <option value="bd">Twice daily (BD)</option>
                                    <option value="tds">Three times daily (TDS)</option>
                                    <option value="qid">Four times daily (QID)</option>
                                    <option value="stat">As needed (PRN)</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Duration *</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., 5 days" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2">Instructions</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="2" placeholder="Take after meals, avoid alcohol, etc."></textarea>
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
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="4" placeholder="Additional advice, follow-up instructions, lifestyle recommendations..."></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Follow-up Date</label>
                        <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Diet Restrictions</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="e.g., Low salt, avoid dairy...">
                    </div>
                </div>
            </div>
            
            <!-- Pharmacy Information -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-clinic-medical mr-2"></i> Pharmacy Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Select Pharmacy *</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" required>
                            <option value="">Select pharmacy</option>
                            <option value="main">DDU Main Campus Pharmacy</option>
                            <option value="west">DDU West Campus Pharmacy</option>
                            <option value="city">City Medical Pharmacy</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Prescription Validity</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                            <option value="7">7 days</option>
                            <option value="15" selected>15 days</option>
                            <option value="30">30 days</option>
                            <option value="90">90 days (chronic)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Save Draft
                </button>
                <button type="button" class="px-6 py-3 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                    Preview
                </button>
                <button type="submit" class="px-6 py-3 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send to Pharmacy</span>
                </button>
            </div>
        </form>
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
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-gray-800">RX-2024-0085</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Salem Asfaw</div>
                                    <div class="text-gray-600 text-sm">Upper Respiratory Infection</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">Amoxicillin</span>
                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded text-xs">Paracetamol</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">Today, 09:00 AM</td>
                        <td class="py-4 px-6">Main Campus</td>
                        <td class="py-4 px-6">
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">Dispensed</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-gray-800">RX-2024-0084</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-pink-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Marta Solomon</div>
                                    <div class="text-gray-600 text-sm">Gastric Ulcer</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                <span class="bg-purple-100 text-purple-800 py-1 px-2 rounded text-xs">Omeprazole</span>
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded text-xs">Antacid</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">Yesterday, 03:45 PM</td>
                        <td class="py-4 px-6">West Campus</td>
                        <td class="py-4 px-6">
                            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-sm font-medium">Pending</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let medicationCount = 0;
        
        // Add first medication
        addMedication();
        
        // Add medication button click
        document.getElementById('addMedication').addEventListener('click', function() {
            addMedication();
        });
        
        // Patient selection change
        document.getElementById('patientSelect').addEventListener('change', function() {
            const patientAge = document.getElementById('patientAge');
            const patientData = {
                '1': '21 years',
                '2': '22 years',
                '3': '23 years',
                '4': '20 years'
            };
            patientAge.value = patientData[this.value] || '';
        });
        
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
            
            // Add remove functionality
            const removeBtn = template.querySelector('.remove-medication');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    if (document.querySelectorAll('.medication-item').length > 1) {
                        template.remove();
                    } else {
                        alert('At least one medication is required.');
                    }
                });
            }
            
            // Add to container
            document.getElementById('medicationsContainer').appendChild(template);
            
            // Animate the new medication
            template.style.opacity = '0';
            template.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                template.style.transition = 'all 0.3s ease';
                template.style.opacity = '1';
                template.style.transform = 'translateY(0)';
            }, 10);
        }
    });
</script>
@endsection