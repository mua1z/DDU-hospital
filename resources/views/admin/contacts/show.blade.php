@extends('admin.layouts.layout')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Message Details') }}
        </h2>
        <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender Name</label>
                    <div class="mt-1 text-lg font-medium text-gray-900">{{ $message->full_name }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Student ID</label>
                    <div class="mt-1 text-lg text-gray-900">{{ $message->student_id ?? 'N/A' }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1 text-lg text-blue-600">
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date Received</label>
                    <div class="mt-1 text-lg text-gray-900">{{ $message->created_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message Content</label>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 min-h-[150px] whitespace-pre-line text-gray-800">
                    {{ $message->message }}
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="mailto:{{ $message->email }}?subject={{ urlencode('RE: DDU Clinic Inquiry - ' . $message->full_name) }}&body={{ urlencode("Dear " . $message->full_name . ",\n\nThank you for contacting DDU Student Clinic.\n\nRegarding your message:\n\"" . substr($message->message, 0, 100) . "...\"\n\nBest regards,\nDDU Student Clinic") }}" 
                   class="px-4 py-2 bg-ddu-primary text-white rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-reply mr-2"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
