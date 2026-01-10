<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            abort(403, 'Patient profile not found.');
        }

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('status', 'scheduled')
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(5)
            ->get();

        $recentRecords = MedicalRecord::where('patient_id', $patient->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact('patient', 'upcomingAppointments', 'recentRecords'));
    }

    public function medicalRecords()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->firstOrFail();

        $records = MedicalRecord::with(['doctor'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->paginate(10);

        return view('patient.medical-records', compact('patient', 'records'));
    }

    public function myAppointments()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->firstOrFail();

        $appointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.my-appointments', compact('patient', 'appointments'));
    }

    // Placeholder for routes that exist in web.php but not explicitly requested, 
    // to prevent errors if they are clicked.
    public function bookAppointment()
    {
        return view('patient.book-appointment');
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->firstOrFail();

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => null, // Specific doctor not selected by patient in this form
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'type' => 'appointment',
            'reason' => $validated['reason'],
            'notes' => $validated['notes'],
            'status' => 'pending', // Pending approval by Reception
            'appointment_number' => 'APT-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'created_by' => $user->id,
        ]);

        // Notify Receptionists (FR-22 requirement implies user notifications, but system needs log too)
        // Ideally we notify 'Receptions' role.
        $receptionists = \App\Models\User::whereIn('role', ['Receptions', 'Admin'])->get();
        // Assuming NewAppointment notification exists and works for reception too, or create generic one.
        // ReceptionController used NewAppointment for Doctors and Patient.
        // We can reuse it or just skip for now to avoid "Class not found" if I didn't create it for Reception usage.
        // Let's rely on Dashboard "Upcoming Appointments" for now, or simple flash message.
        // Step 241 showed NewAppointment.php exists.
        
        foreach ($receptionists as $reception) {
             $reception->notify(new \App\Notifications\NewAppointment($appointment));
        }

        return redirect()->route('patient.dashboard')->with('success', 'Appointment request submitted successfully.');
    }
}
