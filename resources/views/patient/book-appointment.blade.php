@extends('patient.layouts.layout')

@section('title', 'Book Appointment - Patient Portal')
@section('page-title', 'Book Appointment')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Schedule a Visit</h2>
            <p class="text-sm text-gray-500 mt-1">Please fill out the form below to book an appointment.</p>
        </div>
        
        <div class="p-6">
            <form action="{{ route('patient.store-appointment') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Date & Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" min="{{ date('Y-m-d') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                        <div>
                            <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                            <input type="time" name="appointment_time" id="appointment_time" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
                        <textarea name="reason" id="reason" rows="4" placeholder="Briefly describe your symptoms or reason for visit..." required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes (Optional)</label>
                        <input type="text" name="notes" id="notes" placeholder="Any specific requests?"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="pt-4 flex items-center justify-end space-x-4">
                        <a href="{{ route('patient.dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-6 bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start space-x-3">
        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
        <div class="text-sm text-blue-800">
            <p class="font-bold">Note:</p>
            <p>Your appointment request will be reviewed by the reception. You will receive a notification once it is confirmed.</p>
        </div>
    </div>
</div>
@endsection
