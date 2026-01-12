@extends('doctor.layouts.layout')

@section('title', 'View Appointments - DDU Clinics')
@section('page-title', 'Appointments Schedule')
@section('page-subtitle', 'Manage patient appointments')

@section('content')
<div class="animate-slide-up">
    <!-- Appointment Filters -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ request()->fullUrlWithQuery(['period' => 'today']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('period', 'today') === 'today' ? 'bg-ddu-primary text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                    Today
                </a>
                <a href="{{ request()->fullUrlWithQuery(['period' => 'tomorrow']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('period') === 'tomorrow' ? 'bg-ddu-primary text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                    Tomorrow
                </a>
                <a href="{{ request()->fullUrlWithQuery(['period' => 'this_week']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('period') === 'this_week' ? 'bg-ddu-primary text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                    This Week
                </a>
            </div>
            
            <form action="{{ route('doctor.view-appointments') }}" method="GET" class="flex flex-1 md:flex-none items-center space-x-4">
                @if(request('period')) <input type="hidden" name="period" value="{{ request('period') }}"> @endif
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ddu-primary">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <!-- Filter button removed or kept as submit? A search icon is enough usually, but 'Filter' button in design suggests advanced or just submit -->
                <button type="submit" class="px-4 py-2 border border-ddu-primary text-ddu-primary rounded-lg hover:bg-green-50">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </form>
        </div>
    </div>
    
    <!-- Appointments Calendar View -->
    <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">{{ $periodTitle }}</h2>
        </div>
        
        <div class="divide-y">
            @forelse($appointments as $appointment)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                        <div class="w-14 h-14 rounded-full {{ $appointment['bgColor'] }} flex items-center justify-center">
                            <i class="{{ $appointment['icon'] }} {{ $appointment['textColor'] }} text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $appointment['patient'] }}</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">
                                    <i class="fas fa-id-card mr-1"></i> {{ $appointment['cardNo'] }}
                                </span>
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">
                                    <i class="fas fa-user-clock mr-1"></i> {{ $appointment['age'] }} years
                                </span>
                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-medium">
                                    <i class="fas fa-venus-mars mr-1"></i> {{ $appointment['gender'] }}
                                </span>
                            </div>
                            <p class="text-gray-600 mt-2">{{ $appointment['symptoms'] }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col lg:items-end space-y-3">
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-800">{{ $appointment['time'] }}</div>
                             @if(request('period') === 'this_week' || request('search'))
                                <div class="text-sm text-blue-600 font-medium mb-1">{{ $appointment['date'] }}</div>
                            @endif
                            <div class="text-gray-600 font-medium">{{ $appointment['duration'] }}</div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-2">
                            <span class="{{ $appointment['statusClass'] }} py-1 px-3 rounded-full text-sm font-medium">
                                {{ $appointment['status'] }}
                            </span>
                        </div>
                        
                        <div class="flex space-x-2 pt-2">
                            <form action="{{ route('doctor.appointments.consult', $appointment['id']) }}" method="POST" class="inline">
                                @csrf
                                <!-- We need to make sure the route handles GET or we treat "Start" as just going to a page?
                                     The existing route `appointments.consult` is POST.
                                     Usually "Start Consultation" goes to a view. 
                                     The user said "Start Consultation" which implies an action.
                                     Reviewing routes: `Route::post('/appointments/{appointment}/consult', ...)`
                                     So this is the submission. 
                                     Is there a view for *doing* the consultation? 
                                     Wait, `requestLabTest`, `writePrescription` are separate.
                                     Maybe "Start Consultation" should just go to a modal or a page? 
                                     Given existing code, `documentHistory` seems to be the catch-all or there's no specific "Consultation Page" yet.
                                     However, `view-appointments.blade.php` linked to `doctor.document-history`.
                                     Let's keep it linking there or a new page if needed.
                                     Actually, checking `DoctorController`, `consultAppointment` submits data.
                                     For now, let's link to `document-history` as before but maybe with a parameter,
                                     OR just keep the visual button as requested.
                                     I'll assume "Start Consultation" opens the context for that patient. 
                                     Since I don't see a `consult` view route, I will link to `request-lab-test` or `write-prescription` or just `document-history` for now,
                                     or better, `write-prescription` pre-filled?
                                     Let's stick to the previous link `doctor.document-history` but style it as requested.
                                     Wait, the user sees "Start Consultation" text. I will use that.
                                -->
                                <a href="{{ route('doctor.write-prescription', ['appointment_id' => $appointment['id'], 'patient_id' => \App\Models\Appointment::find($appointment['id'])->patient_id]) }}" 
                                   class="px-5 py-2.5 bg-ddu-primary text-white rounded-lg hover:bg-green-700 transition flex items-center shadow-sm">
                                    <i class="fas fa-stethoscope mr-2"></i>
                                    <span>Start Consultation</span>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                No appointments scheduled for today
            </div>
            @endforelse
        </div>
        @if(method_exists($appointments, 'links'))
        <div class="px-6 py-4 border-t">
            {{ $appointments->links() }}
        </div>
        @endif
    </div>
    
    <!-- Upcoming Appointments -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tomorrow's Appointments -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Tomorrow's Schedule</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($tomorrowAppointments as $appt)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-green-300 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $appt['patient'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $appt['reason'] }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-gray-800">{{ $appt['time'] }}</div>
                            <div class="text-gray-600 text-sm">{{ $appt['type'] }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">No appointments scheduled for tomorrow</div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Appointment Statistics -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Weekly Statistics</h2>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Completed</span>
                            <span class="font-bold text-gray-800">{{ $weeklyStats['completed']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $weeklyStats['completed']['percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Pending</span>
                            <span class="font-bold text-gray-800">{{ $weeklyStats['pending']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $weeklyStats['pending']['percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Cancelled</span>
                            <span class="font-bold text-gray-800">{{ $weeklyStats['cancelled']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $weeklyStats['cancelled']['percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">No-show</span>
                            <span class="font-bold text-gray-800">{{ $weeklyStats['no_show']['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-500 h-2 rounded-full" style="width: {{ $weeklyStats['no_show']['percent'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection