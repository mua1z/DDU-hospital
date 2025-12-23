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
                    'id' => $appointment->id,
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

        // Weekly Statistics
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklyAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
            ->get();

        $totalWeekly = $weeklyAppointments->count();
        
        $weeklyStats = [
            'completed' => [
                'count' => $weeklyAppointments->where('status', 'completed')->count(),
                'percent' => $totalWeekly > 0 ? round(($weeklyAppointments->where('status', 'completed')->count() / $totalWeekly) * 100) : 0,
            ],
            'pending' => [
                'count' => $weeklyAppointments->whereIn('status', ['scheduled', 'in_progress'])->count(),
                'percent' => $totalWeekly > 0 ? round(($weeklyAppointments->whereIn('status', ['scheduled', 'in_progress'])->count() / $totalWeekly) * 100) : 0,
            ],
            'cancelled' => [
                'count' => $weeklyAppointments->where('status', 'cancelled')->count(),
                'percent' => $totalWeekly > 0 ? round(($weeklyAppointments->where('status', 'cancelled')->count() / $totalWeekly) * 100) : 0,
            ],
            'no_show' => [
                'count' => $weeklyAppointments->where('status', 'no_show')->count(),
                'percent' => $totalWeekly > 0 ? round(($weeklyAppointments->where('status', 'no_show')->count() / $totalWeekly) * 100) : 0,
            ],
        ];

        return view('doctor.view-appointments', compact('appointments', 'tomorrowAppointments', 'weeklyStats'));
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

        $labRequest = LabRequest::create($validated);

        $labUsers = \App\Models\User::where('role', 'Laboratory')->get();
        foreach ($labUsers as $user) {
            $user->notify(new \App\Notifications\NewLabRequest($labRequest));
        }

        return redirect()->route('doctor.request-lab-test')
            ->with('success', 'Lab test requested successfully.');
    }

    public function writePrescription(Request $request) 
    {
        $patients = Patient::orderBy('full_name')->get();
        // Get appointments for today to pre-fill or link
        $appointments = Appointment::with('patient')
            ->where('doctor_id', auth()->id())
            ->whereDate('appointment_date', now()->toDateString())
            ->get();
            
        $selectedPatient = null;
        if ($request->has('patient_id')) {
            $selectedPatient = Patient::find($request->patient_id);
        }

        return view('doctor.write-prescription', compact('patients', 'appointments', 'selectedPatient'));
    }

    public function storePrescription(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'date' => 'required|date',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'diet_instructions' => 'nullable|string',
            'follow_up' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.frequency' => 'required|string',
            'medicines.*.duration' => 'required|string',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.instructions' => 'nullable|string',
        ]);

        // Generate unique prescription number
        $prescriptionNumber = 'PR-' . strtoupper(Str::random(10));

        $prescription = Prescription::create([
            'prescription_number' => $prescriptionNumber,
            'patient_id' => $validated['patient_id'],
            'appointment_id' => $validated['appointment_id'],
            'prescribed_by' => auth()->id(),
            'diagnosis' => $validated['diagnosis'],
            'notes' => $validated['notes'],
            'prescription_date' => $validated['date'],
            'status' => 'pending',
        ]);

        foreach ($validated['medicines'] as $medData) {
            // Find or create the medication
            $medication = Medication::firstOrCreate(
                ['name' => $medData['name']],
                [
                    // Defaults for a new medication created on the fly
                    'generic_name' => $medData['name'], 
                    'is_active' => true,
                    'requires_prescription' => true
                ]
            );

            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medication_id' => $medication->id,
                'dosage' => $medData['dosage'],
                'frequency' => $medData['frequency'],
                'quantity' => $medData['quantity'],
                // Duration matches the string from dropdown e.g. "5 days". 
                // We might want to parse this to integer days if possible, or just store comments
                // The DB expects integer 'duration_days'. Let's attempt to parse or default to null,
                // and store the string in instructions if needed is not fitting.
                // However, the DB schema for prescription_items uses 'duration_days' (int).
                // The form sends strings like "5 days". Let's extract the integer.
                'duration_days' => intval($medData['duration']), 
                'instructions' => $medData['instructions'],
                'status' => 'pending',
            ]);
        }
        
        // Append extra instructions to notes if present, as there are no dedicated columns on prescription table for these yet
        if (!empty($validated['diet_instructions']) || !empty($validated['follow_up'])) {
            $extraNotes = "";
            if (!empty($validated['diet_instructions'])) {
                $extraNotes .= "\nDidt/Lifestyle: " . $validated['diet_instructions'];
            }
            if (!empty($validated['follow_up'])) {
                $extraNotes .= "\nFollow-up: " . $validated['follow_up'];
            }
            $prescription->notes .= $extraNotes;
            $prescription->save();
            $prescription->save();
        }

        $pharmacists = \App\Models\User::where('role', 'Pharmacist')->get();
        foreach ($pharmacists as $medUser) {
            $medUser->notify(new \App\Notifications\NewPrescription($prescription));
        }

        return redirect()->route('doctor.write-prescription')
            ->with('success', 'Prescription created successfully.');
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

        // Lab Statistics
        $today = now()->toDateString();
        
        // Tests Requested Today
        $testsToday = LabRequest::where('requested_by', $doctorId)
            ->whereDate('created_at', $today)
            ->count();
            
        // Total active requests (for percentage calc)
        $totalActive = LabRequest::where('requested_by', $doctorId)->count();
        
        // Pending Reviews (Pending Lab Requests)
        $pendingCount = LabRequest::where('requested_by', $doctorId)
            ->where('status', 'pending')
            ->count();
            
        // Completed Today (Results uploaded today)
        // We need to check LabResult where related request is by this doctor
        $completedToday = LabResult::whereHas('labRequest', function ($q) use ($doctorId) {
            $q->where('requested_by', $doctorId);
        })->whereDate('created_at', $today)->count();
        
        // Abnormal Results (Critical status)
        $abnormalCount = LabResult::whereHas('labRequest', function ($q) use ($doctorId) {
            $q->where('requested_by', $doctorId);
        })->where('status', 'critical')->count();
        
        // Total Results (for percentage)
        $totalResults = LabResult::whereHas('labRequest', function ($q) use ($doctorId) {
            $q->where('requested_by', $doctorId);
        })->count();

        $labStats = [
            'tests_today' => [
                'count' => $testsToday,
                'percent' => $totalActive > 0 ? round(($testsToday / $totalActive) * 100) : 0,
            ],
            'abnormal' => [
                'count' => $abnormalCount,
                'percent' => $totalResults > 0 ? round(($abnormalCount / $totalResults) * 100) : 0,
            ],
            'pending' => [
                'count' => $pendingCount,
                'percent' => $totalActive > 0 ? round(($pendingCount / $totalActive) * 100) : 0,
            ],
            'completed_today' => [
                'count' => $completedToday,
                'percent' => $totalActive > 0 ? round(($completedToday / $totalActive) * 100) : 0,
            ],
        ];

        return view('doctor.view-lab-results', compact('labResults', 'labStats'));
    }

    public function viewResultDetails($id)
    {
        $doctorId = auth()->id();
        
        $result = LabResult::with(['patient', 'labRequest.requestedBy', 'processedBy'])
            ->whereHas('labRequest', function ($query) use ($doctorId) {
                $query->where('requested_by', $doctorId);
            })
            ->findOrFail($id);

        return view('doctor.view-result-details', compact('result'));
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
