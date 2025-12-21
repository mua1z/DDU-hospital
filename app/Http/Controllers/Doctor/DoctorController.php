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
use Illuminate\Support\Facades\DB;

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
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->orderBy('appointment_time')
            ->get();

        $recentRequests = LabRequest::with(['patient', 'appointment'])
            ->where('requested_by', auth()->id())
            ->orderBy('requested_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('doctor.request-lab-test', compact('patients', 'appointments', 'recentRequests'));
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

        // Only show lab results that have been sent to doctor (status: completed or critical)
        $labResults = LabResult::with(['patient', 'labRequest', 'processedBy'])
            ->whereHas('labRequest', function ($query) use ($doctorId) {
                $query->where('requested_by', $doctorId);
            })
            ->whereIn('status', ['completed', 'critical']) // Only show results sent to doctor
            ->orderBy('test_date', 'desc')
            ->paginate(20);

        return view('doctor.view-lab-results', compact('labResults'));
    }

public function writePrescription()
{ $doctorId = auth()->id();
    $patients = Patient::orderBy('full_name')->get();
    $medications = Medication::where('is_active', true)->orderBy('name')->get();
    $appointments = Appointment::with('patient') ->where('doctor_id', $doctorId) ->whereDate('appointment_date', now()->toDateString()) ->get(); // Get recent prescriptions for this doctor
    $recentPrescriptions = Prescription::with(['patient', 'items.medication', 'prescribedBy']) ->where('prescribed_by', $doctorId) ->orderBy('prescription_date', 'desc') ->orderBy('created_at', 'desc') ->limit(10) ->get();
     return view('doctor.write-prescription', compact('patients', 'medications', 'appointments', 'recentPrescriptions')); }

   public function storePrescription(Request $request)
{
    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'medications' => 'required|array|min:1',
        'medications.*.medication_id' => 'required|exists:medications,id',
        'medications.*.dosage' => 'required',
        'medications.*.frequency' => 'required',
        'medications.*.quantity' => 'required|integer|min:1',
    ]);

    $prescription = Prescription::create([
        'patient_id' => $request->patient_id,
        'doctor_id' => auth()->id(),
        'diagnosis' => $request->diagnosis,
        'notes' => $request->notes,
        'status' => 'sent_to_pharmacy',
    ]);

    foreach ($request->medications as $med) {
        PrescriptionItem::create([
            'prescription_id' => $prescription->id,
            'medication_id' => $med['medication_id'],
            'dosage' => $med['dosage'],
            'frequency' => $med['frequency'],
            'quantity' => $med['quantity'],
            'duration_days' => $med['duration_days'] ?? null,
            'instructions' => $med['instructions'] ?? null,
        ]);
    }

    return redirect()->back()->with('success', 'Prescription sent to pharmacy successfully.');
}


    public function consultAppointment(Request $request, Appointment $appointment)
    {
        // Ensure the logged in doctor owns this appointment
        if ($appointment->doctor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'consultation_notes' => 'nullable|string',
            'prescription' => 'nullable|array',
            'prescription.diagnosis' => 'nullable|string',
            'prescription.notes' => 'nullable|string',
            'prescription.medications' => 'nullable|array',
            'prescription.medications.*.medication_id' => 'required_with:prescription.medications|exists:medications,id',
            'prescription.medications.*.dosage' => 'required_with:prescription.medications|string',
            'prescription.medications.*.frequency' => 'required_with:prescription.medications|string',
            'prescription.medications.*.quantity' => 'required_with:prescription.medications|integer|min:1',
            'prescription.medications.*.duration_days' => 'nullable|integer',
            'prescription.medications.*.instructions' => 'nullable|string',
            'lab_request' => 'nullable|array',
            'lab_request.test_type' => 'required_with:lab_request|string|max:255',
            'lab_request.test_description' => 'nullable|string',
            'lab_request.clinical_notes' => 'nullable|string',
            'lab_request.priority' => 'nullable|in:normal,urgent,stat',
            'lab_request.due_date' => 'nullable|date',
        ]);

        // Update appointment notes and status
        $notesAppend = $validated['consultation_notes'] ?? null;
        if ($notesAppend) {
            $appointment->notes = ($appointment->notes ? $appointment->notes . "\n\n" : '') . $notesAppend;
        }
        $appointment->status = 'completed';
        $appointment->save();

        // Optionally create a prescription tied to this appointment
        if (!empty($validated['prescription']['medications'])) {
            $pres = $validated['prescription'];
            $prescription = Prescription::create([
                'prescription_number' => 'RX' . strtoupper(Str::random(8)),
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'prescribed_by' => auth()->id(),
                'diagnosis' => $pres['diagnosis'] ?? null,
                'notes' => $pres['notes'] ?? null,
                'status' => 'pending',
                'prescription_date' => now()->toDateString(),
            ]);

            foreach ($pres['medications'] as $med) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medication_id' => $med['medication_id'],
                    'dosage' => $med['dosage'],
                    'frequency' => $med['frequency'],
                    'quantity' => $med['quantity'],
                    'duration_days' => $med['duration_days'] ?? null,
                    'instructions' => $med['instructions'] ?? null,
                    'status' => 'pending',
                ]);
            }
        }

        // Optionally create a lab request tied to this appointment
        if (!empty($validated['lab_request']['test_type'])) {
            $lab = $validated['lab_request'];
            LabRequest::create([
                'request_number' => 'REQ' . strtoupper(Str::random(8)),
                'patient_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'test_type' => $lab['test_type'],
                'test_description' => $lab['test_description'] ?? null,
                'clinical_notes' => $lab['clinical_notes'] ?? null,
                'priority' => $lab['priority'] ?? 'normal',
                'due_date' => $lab['due_date'] ?? null,
                'requested_by' => auth()->id(),
                'requested_date' => now()->toDateString(),
                'status' => 'pending',
            ]);
        }

        return redirect()->back()->with('success', 'Consultation recorded successfully.');
    }

    public function documentHistory()
    {
        $patients = Patient::orderBy('full_name')->get();

        // Recent visit history placeholder; in production, source from real encounters/appointments
        $visitHistory = Appointment::with('patient', 'doctor')
            ->where('doctor_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($appointment) {
                return [
                    'date' => ($appointment->appointment_date ? $appointment->appointment_date->format('M d, Y') : $appointment->created_at->format('M d, Y'))
                        . ', ' . \Carbon\Carbon::parse($appointment->appointment_time ?? $appointment->created_at)->format('h:i A'),
                    'diagnosis' => $appointment->reason ?? 'Consultation',
                    'doctor' => $appointment->doctor->name ?? 'Doctor',
                    'status' => ucfirst(str_replace('_', ' ', $appointment->status ?? 'scheduled')),
                    'statusColor' => $appointment->status === 'in_progress' ? 'text-green-600' : 'text-blue-600',
                    'borderColor' => $appointment->status === 'in_progress' ? 'border-green-500' : 'border-blue-500',
                    'treatments' => [], // populate when treatments are available
                ];
            })
            ->toArray();

        return view('doctor.document-history', compact('patients', 'visitHistory'));
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
