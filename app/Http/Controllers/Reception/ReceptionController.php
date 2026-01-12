<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\ReportService;
use App\Exports\PatientsExport;
use App\Exports\AppointmentsExport;
use Maatwebsite\Excel\Facades\Excel;

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
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'], // Text only (letters, spaces, dots)
            'card_number' => ['required', 'string', 'alpha_num', 'unique:patients,card_number'], // Alphanumeric
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female', // Enforce Male/Female for DB Enum
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\s]+$/'], 
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'], 
            'emergency_contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\s]+$/'], 
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Add password validation
        ]);

        $validated['registered_by'] = auth()->id();
        // Capitalize gender to match DB ENUM ('Male', 'Female')
        if (isset($validated['gender'])) {
            $validated['gender'] = ucfirst($validated['gender']);
        }

        // Generate DDUC ID
        $dduc_id = strtoupper($validated['card_number']);
        if (! Str::startsWith($dduc_id, 'DDUC')) {
            $dduc_id = 'DDUC' . $dduc_id;
        }

        // Create User account for the patient
        $user = User::create([
            'name' => $validated['full_name'],
            'dduc_id' => $dduc_id, 
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']), // Use provided password
            'role' => 'Patient', // Capitalized standard role
            'is_active' => true,
        ]);
        
        $validated['user_id'] = $user->id;

        $patient = Patient::create($validated);

        // Notify doctors of new registration (FR-22 requirement)
        $doctors = User::whereIn('role', ['Doctor', 'Doctors', 'Admin'])->get();
        foreach ($doctors as $doc) {
            $doc->notify(new \App\Notifications\NewPatientRegistration($patient));
        }

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

    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('reception.edit-patient', compact('patient'));
    }

    public function updatePatient(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'card_number' => ['required', 'string', 'alpha_num', 'unique:patients,card_number,' . $id],
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female',
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\s]+$/'],
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\s]+$/'],
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        // Capitalize gender to match DB ENUM ('Male', 'Female')
        if (isset($validated['gender'])) {
            $validated['gender'] = ucfirst($validated['gender']);
        }

        $patient->update($validated);

        // Update user name if changed
        if ($patient->user_id && $patient->user->name !== $validated['full_name']) {
            $patient->user->update(['name' => $validated['full_name']]);
        }

        return redirect()->route('reception.view-patient', $patient->id)
            ->with('success', 'Patient information updated successfully.');
    }

    public function scheduleAppointments()
    {
        $doctors = User::whereIn('role', ['Doctor', 'Doctors'])->get();
        $patients = Patient::orderBy('full_name')->get();
        
        // Items requiring attention (Online requests or Unassigned)
        $pendingRequests = Appointment::with(['patient'])
            ->where(function($query) {
                $query->where('status', 'pending')
                      ->orWhereNull('doctor_id');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereNotNull('doctor_id') // Only show assigned appointments in the main list
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(20);

        return view('reception.schedule-appointments', compact('doctors', 'patients', 'appointments', 'pendingRequests'));
    }

    public function approveRequest(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
        ]);

        $appointment->doctor_id = $validated['doctor_id'];
        $appointment->status = 'scheduled'; // Confirm status
        $appointment->save();

        // Notify Doctor
        $doctor = User::find($appointment->doctor_id);
        if ($doctor) {
            $doctor->notify(new \App\Notifications\NewAppointment($appointment));
        }

        // Notify Patient
        if ($appointment->patient && $appointment->patient->user_id) {
             $patientUser = User::find($appointment->patient->user_id);
             // Verify we have a generic notification or create one. Reusing NewAppointment is risky if it assumes doctor perspective.
             // But for now it's okay, or use database notification directly.
             // Ideally we'd have AppointmentConfirmed notification.
        }

        return redirect()->back()->with('success', 'Appointment approved and doctor assigned.');
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

        if ($validated['type'] === 'walk_in') {
            // Assume walk-ins might be emergencies or at least urgent
             $appointment->notes = ($appointment->notes ? $appointment->notes . "\n" : "") . "[URGENT CASE]";
             $appointment->save();
             
             // Notify doctors/admins of emergency case (FR-22)
             $recipients = User::whereIn('role', ['Doctor', 'Doctors', 'Admin'])->get();
             foreach ($recipients as $recipient) {
                 $recipient->notify(new \App\Notifications\NewEmergencyCase($appointment));
             }
        }

        if ($appointment->doctor_id) {
            $doctor = User::find($appointment->doctor_id);
            if ($doctor) {
                $doctor->notify(new \App\Notifications\NewAppointment($appointment));
            }
        }

        // Notify patient if they have a user account
        if ($appointment->patient && $appointment->patient->user_id) {
             $patientUser = User::find($appointment->patient->user_id);
             if ($patientUser) {
                 $patientUser->notify(new \App\Notifications\NewAppointment($appointment));
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

    /**
     * Export patients as PDF
     */
    public function exportPatientsPDF()
    {
        $patients = Patient::orderBy('created_at', 'desc')->get();
        
        $reportService = new ReportService();
        return $reportService->generatePDF(
            ['patients' => $patients],
            'reports.patients-pdf',
            'patients-report-' . now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Export patients as Excel
     */
    public function exportPatientsExcel()
    {
        $patients = Patient::orderBy('created_at', 'desc')->get();
        
        return Excel::download(
            new PatientsExport($patients),
            'patients-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export appointments as PDF
     */
    public function exportAppointmentsPDF()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();
        
        $reportService = new ReportService();
        return $reportService->generatePDF(
            ['appointments' => $appointments],
            'reports.appointments-pdf',
            'appointments-report-' . now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Export appointments as Excel
     */
    public function exportAppointmentsExcel()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();
        
        return Excel::download(
            new AppointmentsExport($appointments),
            'appointments-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
