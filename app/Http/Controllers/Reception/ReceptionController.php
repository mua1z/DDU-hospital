<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();
        
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();
        
        $recentPatients = Patient::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('reception.dashboard', compact('todayAppointments', 'recentPatients'));
    }

    public function registerPatient()
    {
        return view('reception.register-patient');
    }

    public function storePatient(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'card_number' => 'required|string|unique:patients,card_number',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $validated['registered_by'] = auth()->id();

        Patient::create($validated);

        return redirect()->route('reception.search-patients')
            ->with('success', 'Patient registered successfully.');
    }

    public function searchPatients(Request $request)
    {
        $query = $request->get('q');
        $patients = collect();

        if ($query) {
            $patients = Patient::where('full_name', 'like', "%{$query}%")
                ->orWhere('card_number', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('reception.search-patients', compact('patients', 'query'));
    }

    public function viewPatient($id)
    {
        $patient = Patient::with(['appointments', 'prescriptions', 'labRequests', 'medicalRecords.doctor'])
            ->findOrFail($id);

        return view('reception.view-patient', compact('patient'));
    }

    public function scheduleAppointments()
    {
        $doctors = User::where('role', 'Doctors')->get();
        $patients = Patient::orderBy('full_name')->get();
        
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(20);

        return view('reception.schedule-appointments', compact('doctors', 'patients', 'appointments'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type' => 'required|in:appointment,walk_in',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['appointment_number'] = 'APT-' . strtoupper(Str::random(8));
        $validated['status'] = 'scheduled';
        $validated['created_by'] = auth()->id();

        $appointment = Appointment::create($validated);

        if ($appointment->doctor_id) {
            $doctor = User::find($appointment->doctor_id);
            if ($doctor) {
                $doctor->notify(new \App\Notifications\NewAppointment($appointment));
            }
        }

        return redirect()->route('reception.schedule-appointments')
            ->with('success', 'Appointment scheduled successfully.');
    }

    public function manageWalkin()
    {
        $walkIns = Appointment::with(['patient', 'doctor'])
            ->where('type', 'walk_in')
            ->whereDate('appointment_date', now()->toDateString())
            ->orderBy('appointment_time')
            ->get();

        return view('reception.manage-walkin', compact('walkIns'));
    }
}
