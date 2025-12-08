@extends('reception.layouts.layout')

@section('title', 'Register Patient - DDU Clinics')
@section('page-title', 'Register New Patient')
@section('page-subtitle', 'Patient Registration Form')

@section('content')
<div class="animate-slide-up">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Patient Information</h2>
        
        <form action="{{ route('reception.store-patient') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2">Personal Details</h3>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Full Name *</label>
                        <input type="text" name="full_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="Enter full name" value="{{ old('full_name') }}" required>
                        @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Student ID / Card No. *</label>
                        <input type="text" name="card_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="STUXXXX" value="{{ old('card_number') }}" required>
                        @error('card_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" value="{{ old('date_of_birth') }}">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender</label>
                        <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-700 border-b pb-2">Contact Details</h3>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Phone Number</label>
                        <input type="tel" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="+251 XX XXX XXXX" value="{{ old('phone') }}">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="student@ddu.edu.et" value="{{ old('email') }}">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Address</label>
                        <textarea name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="2" placeholder="Address...">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Medical Information -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2">Medical Information</h3>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Known Allergies</label>
                    <textarea name="allergies" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="2" placeholder="List any allergies...">{{ old('allergies') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Medical History</label>
                    <textarea name="medical_history" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" rows="3" placeholder="Any relevant medical history...">{{ old('medical_history') }}</textarea>
                </div>
            </div>
            
            <!-- Emergency Contact -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2">Emergency Contact</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Emergency Contact Name</label>
                        <input type="text" name="emergency_contact_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="Full name" value="{{ old('emergency_contact_name') }}">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Emergency Contact Phone</label>
                        <input type="tel" name="emergency_contact_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary" placeholder="Phone number" value="{{ old('emergency_contact_phone') }}">
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('reception.dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-ddu-primary text-white rounded-lg hover:bg-blue-700 transition">
                    Register Patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection