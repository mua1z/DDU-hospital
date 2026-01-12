<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\LabRequest;
use App\Models\LabResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ReportService;
use App\Exports\LabResultsExport;
use Maatwebsite\Excel\Facades\Excel;

class LabController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'pending_tests' => LabRequest::where('status', 'pending')->count(),
            'today_tests' => LabRequest::whereDate('requested_date', now()->toDateString())->count(),
            'results_pending' => LabResult::where('status', 'pending')->count(),
            'critical_results' => LabResult::where('status', 'critical')->count(),
        ];

        $pendingRequests = LabRequest::with(['patient', 'requestedBy'])
            ->where('status', 'pending')
            ->orderBy('priority', 'desc')
            ->orderBy('requested_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentResults = LabResult::with(['patient', 'labRequest'])
            ->orderBy('test_date', 'desc')
            ->limit(5)
            ->get();

        return view('lab.dashboard', compact('stats', 'pendingRequests', 'recentResults'));
    }

    public function pendingRequests()
    {
        $requests = LabRequest::with(['patient', 'requestedBy', 'appointment'])
            ->where('status', 'pending')
            ->orderBy('priority', 'desc')
            ->orderBy('requested_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('lab.view-requests', compact('requests'));
    }

    public function viewRequestDetails($id)
    {
        $request = LabRequest::with(['patient', 'requestedBy'])
            ->findOrFail($id);

        return view('lab.view-request-details', compact('request'));
    }

    public function processTest($id)
    {
        $request = LabRequest::with(['patient', 'requestedBy'])
            ->findOrFail($id);

        return view('lab.process-test', compact('request'));
    }

    public function updateRequestStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $labRequest = LabRequest::findOrFail($id);
        $labRequest->update($validated);

        return redirect()->back()->with('success', 'Request status updated.');
    }

    public function uploadResults(Request $request)
    {
        $requests = LabRequest::with(['patient', 'requestedBy'])
            ->whereIn('status', ['pending', 'in_progress', 'completed'])
            ->orderBy('requested_date', 'desc') // Order by date (newest first)
            ->orderBy('created_at', 'desc') // Then by time (newest first)
            ->orderBy('priority', 'desc') // Then by priority
            ->paginate(10);

        $selectedRequest = null;
        $selectedId = $request->get('request_id');

        if ($selectedId) {
            $selectedRequest = LabRequest::with(['patient', 'requestedBy'])->find($selectedId);
        }

        if (!$selectedRequest && $requests->isNotEmpty()) {
            $selectedRequest = $requests->first();
        }

        return view('lab.upload-results', compact('requests', 'selectedRequest'));
    }

    public function storeResults(Request $request)
    {
        $validated = $request->validate([
            'lab_request_id' => 'required|exists:lab_requests,id',
            'results' => 'nullable|string', // Text/Mixed
            'test_values' => 'nullable|string', // Allow any text
            'findings' => 'nullable|string', // Text/Mixed  
            'recommendations' => 'nullable|string', // Text/Mixed
            'status' => 'required|in:pending,completed,critical',
            'test_date' => 'required|date',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $labRequest = LabRequest::findOrFail($validated['lab_request_id']);

        if ($request->hasFile('result_file')) {
            if ($request->file('result_file')->isValid()) {
                $validated['result_file'] = $request->file('result_file')->store('lab-results', 'public');
            } else {
                 return back()->with('error', 'Uploaded file is not valid.');
            }
        }

        $validated['patient_id'] = $labRequest->patient_id;
        $validated['processed_by'] = auth()->id();
        $validated['result_date'] = now()->toDateString();

        if (isset($validated['test_values']) && $validated['test_values']) {
            $rawValues = $validated['test_values'];
            $decoded = json_decode($rawValues, true);
            
            // IF valid JSON and is array
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $validated['test_values'] = $decoded;
            } else {
                // Formatting raw text into the structure expected by views
                $validated['test_values'] = [
                    [
                        'name' => 'Result Details',
                        'value' => $rawValues,
                        'unit' => '',
                        'reference' => ''
                    ]
                ];
            }
        }

        $labResult = LabResult::updateOrCreate(
            ['lab_request_id' => $validated['lab_request_id']],
            $validated
        );

        $labRequest->update(['status' => 'completed']);

        if ($labRequest->requestedBy) {
            $labRequest->requestedBy->notify(new \App\Notifications\LabResultUploaded($labResult));
        }

        return redirect()->route('lab.upload-results')
            ->with('success', 'Lab results uploaded successfully.');
    }

    public function testResults()
    {
        $results = LabResult::with(['patient', 'labRequest', 'processedBy'])
            ->orderBy('test_date', 'desc')
            ->paginate(20);

        return view('lab.test-results', compact('results'));
    }

    public function viewResultDetails($id)
    {
        $result = LabResult::with(['patient', 'labRequest.requestedBy', 'processedBy'])
            ->findOrFail($id);

        return view('lab.view-result-details', compact('result'));
    }

    public function inventory()
    {
        // Placeholder for inventory management
        return view('lab.inventory');
    }

    public function qualityControl()
    {
        // Placeholder for quality control
        return view('lab.quality-control');
    }

    /**
     * Export lab results as PDF
     */
    public function exportResultsPDF()
    {
        $results = LabResult::with(['patient', 'labRequest', 'processedBy'])
            ->orderBy('test_date', 'desc')
            ->get();
        
        $reportService = new ReportService();
        return $reportService->generatePDF(
            ['results' => $results],
            'reports.lab-results-pdf',
            'lab-results-' . now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Export lab results as Excel
     */
    public function exportResultsExcel()
    {
        $results = LabResult::with(['patient', 'labRequest', 'processedBy'])
            ->orderBy('test_date', 'desc')
            ->get();
        
        return Excel::download(
            new LabResultsExport($results),
            'lab-results-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
