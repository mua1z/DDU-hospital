@extends('doctor.layouts.layout')

@section('title', 'Doctor Dashboard - DDU Clinics')
@section('page-title')
{{ __('Welcome, Dr.') }} {{ auth()->user()->name }}
@endsection
@section('page-subtitle', __('Today\'s Overview'))

@section('content')
<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slide-up">
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Today\'s Appointments') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['today_appointments'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('doctor.view-appointments') }}" class="text-blue-600 text-sm font-medium hover:underline">{{ __('View All') }} →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Pending Lab Results') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['pending_lab_results'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-flask text-yellow-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('doctor.view-lab-results') }}" class="text-yellow-600 text-sm font-medium hover:underline">{{ __('Check Results') }} →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Prescriptions Today') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['prescriptions_today'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-prescription text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('doctor.write-prescription') }}" class="text-green-600 text-sm font-medium hover:underline">{{ __('Write New') }} →</a>
        </div>
    </div>
    
    <div class="dashboard-card bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">{{ __('Urgent Cases') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['urgent_cases'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('doctor.view-appointments') }}" class="text-red-600 text-sm font-medium hover:underline">{{ __('Attend Now') }} →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Today's Schedule -->
    <div class="lg:col-span-2 animate-slide-up" style="animation-delay: 0.1s">
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">{{ __('Today\'s Schedule') }}</h2>
                    <a href="{{ route('doctor.view-appointments') }}" class="text-ddu-primary hover:underline font-medium">{{ __('View All') }}</a>
                </div>
            </div>
            
            <div class="divide-y">
                @forelse($todayAppointments as $appointment)
                <div class="p-6 hover:bg-gray-50 transition flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full {{ $appointment['bgColor'] }} flex items-center justify-center">
                            <i class="{{ $appointment['icon'] }} {{ $appointment['textColor'] }}"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $appointment['patient'] }}</h3>
                            <p class="text-gray-600 text-sm">{{ $appointment['details'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-medium text-gray-800">{{ $appointment['time'] }}</div>
                        <span class="{{ $appointment['statusClass'] }} text-xs font-medium py-1 px-3 rounded-full">
                            {{ $appointment['status'] }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-500">No appointments scheduled for today</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="animate-slide-up" style="animation-delay: 0.2s">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
            
            <div class="space-y-4">
                <a href="{{ route('doctor.write-prescription') }}" class="flex items-center space-x-4 p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-prescription-bottle-alt text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Write Prescription</h3>
                        <p class="text-gray-600 text-sm">Send to pharmacy</p>
                    </div>
                </a>
                
                <a href="{{ route('doctor.request-lab-test') }}" class="flex items-center space-x-4 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-flask text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Request Lab Test</h3>
                        <p class="text-gray-600 text-sm">Blood, urine, etc.</p>
                    </div>
                </a>
                
                <a href="{{ route('doctor.document-history') }}" class="flex items-center space-x-4 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-history text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">{{ __('Document History') }}</h3>
                        <p class="text-gray-600 text-sm">{{ __('Document Patient History') }}</p>
                    </div>
                </a>
                
                <a href="{{ route('doctor.view-lab-results') }}" class="flex items-center space-x-4 p-4 rounded-lg border border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-file-medical-alt text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Review Lab Results</h3>
                        <p class="text-gray-600 text-sm">Check pending tests</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Patients -->
<div class="mt-8 animate-slide-up" style="animation-delay: 0.3s">
    <div class="bg-white rounded-xl shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">{{ __('Recent Patients') }}</h2>
                <a href="{{ route('doctor.document-history') }}" class="text-ddu-primary hover:underline font-medium">{{ __('View All') }}</a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-ddu-light">
                    <tr>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">{{ __('Patient Name') }}</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">{{ __('Visit Time') }}</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">{{ __('Condition') }}</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">{{ __('Status') }}</th>
                        <th class="py-3 px-6 text-left text-gray-700 font-semibold">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPatients as $appointment)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $appointment->patient->full_name }}</div>
                                    <div class="text-gray-600 text-sm">
                                        {{ $appointment->patient->card_number }}
                                        @if($appointment->patient->date_of_birth)
                                            • {{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} years
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                        <td class="py-4 px-6">{{ $appointment->reason ?? 'General Consultation' }}</td>
                        <td class="py-4 px-6">
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm font-medium">{{ ucfirst($appointment->status) }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('doctor.document-history') }}" class="text-ddu-primary hover:underline font-medium">View History</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">No recent patients</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection