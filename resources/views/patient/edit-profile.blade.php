@extends('patient.layouts.layout')

@section('title', 'Edit Profile - DDU Clinics')
@section('page-title', 'Edit My Profile')
@section('page-subtitle', 'Update your personal and contact information')

@section('content')
<div class="animate-slide-up max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Update Profile Information</h2>
            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm">
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('patient.update-profile') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-user mr-2"></i> Personal Information
                </h3>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Full Name *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $patient->full_name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror" required>
                    @error('full_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Read-only demographic info -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-3"><i class="fas fa-info-circle mr-1"></i> The following information cannot be changed. Please contact reception if updates are needed.</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1">Card Number</label>
                            <p class="font-medium text-gray-800">{{ $patient->card_number }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1">Date of Birth</label>
                            <p class="font-medium text-gray-800">{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'Not set' }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1">Gender</label>
                            <p class="font-medium text-gray-800">{{ ucfirst($patient->gender ?? 'Not set') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-address-book mr-2"></i> Contact Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" placeholder="+251-XXX-XXXX">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Address</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror" placeholder="Enter your full address">{{ old('address', $patient->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-phone-alt mr-2"></i> Emergency Contact
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Emergency Contact Name</label>
                        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('emergency_contact_name') border-red-500 @enderror" placeholder="Contact person's name">
                        @error('emergency_contact_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Emergency Contact Phone</label>
                        <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('emergency_contact_phone') border-red-500 @enderror" placeholder="+251-XXX-XXXX">
                        @error('emergency_contact_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Medical Information (Read-only) -->
            @if($patient->medical_history || $patient->allergies)
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 border-b pb-2 flex items-center">
                    <i class="fas fa-notes-medical mr-2"></i> Medical Information
                </h3>
                
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <p class="text-sm text-blue-800 mb-3">
                        <i class="fas fa-lock mr-1"></i> Medical information is managed by healthcare providers and cannot be edited here.
                    </p>
                    
                    @if($patient->medical_history)
                    <div class="mb-3">
                        <label class="block text-gray-700 text-xs font-medium mb-1">Medical History</label>
                        <p class="text-gray-800 text-sm bg-white rounded p-3">{{ $patient->medical_history }}</p>
                    </div>
                    @endif

                    @if($patient->allergies)
                    <div>
                        <label class="block text-gray-700 text-xs font-medium mb-1">Known Allergies</label>
                        <p class="text-gray-800 text-sm bg-white rounded p-3">{{ $patient->allergies }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('patient.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
