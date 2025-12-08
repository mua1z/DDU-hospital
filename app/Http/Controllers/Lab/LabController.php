<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\LabRequest;
use App\Models\LabResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->orderBy('requested_date')
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
            ->orderBy('requested_date')
            ->paginate(20);

        return view('lab.view-requests', compact('requests'));
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

    public function uploadResults()
    {
        $requests = LabRequest::with(['patient'])
            ->where('status', 'in_progress')
            ->orWhere('status', 'completed')
            ->orderBy('requested_date', 'desc')
            ->get();

        return view('lab.upload-results', compact('requests'));
    }

    public function storeResults(Request $request)
    {
        $validated = $request->validate([
            'lab_request_id' => 'required|exists:lab_requests,id',
            'results' => 'nullable|string',
            'test_values' => 'nullable|json',
            'findings' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'status' => 'required|in:pending,completed,critical',
            'test_date' => 'required|date',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $labRequest = LabRequest::findOrFail($validated['lab_request_id']);

        if ($request->hasFile('result_file')) {
            $validated['result_file'] = $request->file('result_file')->store('lab-results', 'public');
        }

        $validated['patient_id'] = $labRequest->patient_id;
        $validated['processed_by'] = auth()->id();
        $validated['result_date'] = now()->toDateString();

        if ($validated['test_values']) {
            $validated['test_values'] = json_decode($validated['test_values'], true);
        }

        $labResult = LabResult::updateOrCreate(
            ['lab_request_id' => $validated['lab_request_id']],
            $validated
        );

        $labRequest->update(['status' => 'completed']);

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
}
