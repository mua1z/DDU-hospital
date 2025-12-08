<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctorId = auth()->id();
        $today = now()->toDateString();

        $todayAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get()
            ->map(function ($appointment) {
                return [
                    'patient' => $appointment->patient->full_name,
                    'details' => $appointment->reason ?? 'General Consultation',
                    'time' => $appointment->appointment_time->format('h:i A'),
                    'status' => ucfirst($appointment->status),
                    'statusClass' => $this->getStatusClass($appointment->status),
                    'icon' => 'fas fa-user-md',
                    'bgColor' => 'bg-green-100',
                    'textColor' => 'text-green-600',
                ];
            });

        $stats = [
            'today_appointments' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $today)
                ->count(),
            'pending_lab_results' => LabRequest::where('requested_by', $doctorId)
                ->where('status', 'pending')
                ->count(),
            'prescriptions_today' => Prescription::where('prescribed_by', $doctorId)
                ->whereDate('prescription_date', $today)
                ->count(),
            'urgent_cases' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $today)
                ->where('status', 'in_progress')
                ->count(),
        ];

        $recentPatients = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->limit(5)
            ->get();

        return view('doctor.dashboard', compact('todayAppointments', 'stats', 'recentPatients'));
    }

    public function viewAppointments()
    {
        $doctorId = auth()->id();
        $today = now()->toDateString();
        $tomorrow = \Carbon\Carbon::tomorrow()->toDateString();
        
        // Today's appointments formatted
        $appointments = Appointment::with(['patient'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get()
            ->map(function ($appointment) {
                return [
                    'patient' => $appointment->patient->full_name,
                    'cardNo' => $appointment->patient->card_number,
                    'age' => \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age,
                    'gender' => $appointment->patient->gender,
                    'symptoms' => $appointment->reason ?? 'General Consultation',
                    'time' => \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A'),
                    'duration' => '30 min consultation',
                    'status' => ucfirst(str_replace('_', ' ', $appointment->status)),
                    'statusClass' => $this->getStatusClass($appointment->status),
                    'priority' => $appointment->type === 'urgent' ? 'high' : 'medium',
                    'icon' => 'fas fa-user-md',
                    'bgColor' => $appointment->patient->gender === 'Female' ? 'bg-pink-100' : 'bg-blue-100',
                    'textColor' => $appointment->patient->gender === 'Female' ? 'text-pink-600' : 'text-blue-600',
                ];
            });

        // Tomorrow's appointments formatted
        $tomorrowAppointments = Appointment::with(['patient'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $tomorrow)
            ->orderBy('appointment_time')
            ->get()
            ->map(function ($appointment) {
                return [
                    'patient' => $appointment->patient->full_name,
                    'reason' => $appointment->reason ?? 'General Consultation',
                    'time' => \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A'),
                    'type' => ucfirst($appointment->type ?? 'Routine'),
                ];
            });

        return view('doctor.view-appointments', compact('appointments', 'tomorrowAppointments'));
    }

    public function requestLabTest()
    {
        $patients = Patient::orderBy('full_name')->get();
        $appointments = Appointment::with('patient')
            ->where('doctor_id', auth()->id())
            ->whereDate('appointment_date', now()->toDateString())
            ->get();

        return view('doctor.request-lab-test', compact('patients', 'appointments'));
    }

    public function storeLabRequest(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'test_type' => 'required|string|max:255',
            'test_description' => 'nullable|string',
            'clinical_notes' => 'nullable|string',
            'priority' => 'required|in:normal,urgent,stat',
            'due_date' => 'nullable|date',
        ]);

        $validated['request_number'] = 'REQ' . strtoupper(Str::random(8));
        $validated['requested_by'] = auth()->id();
        $validated['requested_date'] = now()->toDateString();
        $validated['status'] = 'pending';

        LabRequest::create($validated);

        return redirect()->route('doctor.request-lab-test')
            ->with('success', 'Lab test requested successfully.');
    }

    public function viewLabResults()
    {
        $doctorId = auth()->id();
        
        $labResults = LabResult::with(['patient', 'labRequest'])
            ->whereHas('labRequest', function ($query) use ($doctorId) {
                $query->where('requested_by', $doctorId);
            })
            ->orderBy('test_date', 'desc')
            ->paginate(20);

        return view('doctor.view-lab-results', compact('labResults'));
    }

    public function writePrescription()
    {
        $patients = Patient::orderBy('full_name')->get();
        $medications = Medication::where('is_active', true)->orderBy('name')->get();
        $appointments = Appointment::with('patient')
            ->where('doctor_id', auth()->id())
            ->whereDate('appointment_date', now()->toDateString())
            ->get();

        return view('doctor.write-prescription', compact('patients', 'medications', 'appointments'));
    }

    public function storePrescription(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'medications' => 'required|array|min:1',
            'medications.*.medication_id' => 'required|exists:medications,id',
            'medications.*.dosage' => 'required|string',
            'medications.*.frequency' => 'required|string',
            'medications.*.quantity' => 'required|integer|min:1',
            'medications.*.duration_days' => 'nullable|integer',
            'medications.*.instructions' => 'nullable|string',
        ]);

        $prescription = Prescription::create([
            'prescription_number' => 'RX' . strtoupper(Str::random(8)),
            'patient_id' => $validated['patient_id'],
            'appointment_id' => $validated['appointment_id'] ?? null,
            'prescribed_by' => auth()->id(),
            'diagnosis' => $validated['diagnosis'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'prescription_date' => now()->toDateString(),
        ]);

        foreach ($validated['medications'] as $medication) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medication_id' => $medication['medication_id'],
                'dosage' => $medication['dosage'],
                'frequency' => $medication['frequency'],
                'quantity' => $medication['quantity'],
                'duration_days' => $medication['duration_days'] ?? null,
                'instructions' => $medication['instructions'] ?? null,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('doctor.write-prescription')
            ->with('success', 'Prescription created successfully.');
    }

    public function documentHistory()
    {
        $patients = Patient::orderBy('full_name')->get();
        
        return view('doctor.document-history', compact('patients'));
    }

    private function getStatusClass($status)
    {
        return match($status) {
            'completed' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'scheduled' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
