<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Medication;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ReportService;
use App\Exports\InventoryExport;
use App\Exports\PrescriptionsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Notifications\LowStockAlert;
use Illuminate\Support\Facades\Notification;

class PharmacyController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        $stats = [
            'pending_prescriptions' => Prescription::where('status', 'pending')->count(),
            'today_dispensed' => Prescription::where('status', 'dispensed')
                ->whereDate('updated_at', $today)
                ->count(),
            'low_stock_items' => Inventory::whereColumn('quantity', '<=', 'minimum_stock_level')
                ->where('location', 'pharmacy')
                ->count(),
            'expiring_soon' => Inventory::where('location', 'pharmacy')
                ->whereBetween('expiry_date', [now(), now()->addDays(30)])
                ->count(),
            'out_of_stock' => Inventory::where('location', 'pharmacy')
                ->where('quantity', 0)
                ->count(),
            'medications_dispensed' => PrescriptionItem::where('status', 'dispensed')
                ->whereDate('updated_at', $today)
                ->count(),
        ];

        $recentPrescriptions = Prescription::with(['patient', 'prescribedBy', 'items.medication'])
            ->where('status', 'pending')
            ->orderBy('prescription_date', 'desc')
            ->limit(5)
            ->get();

        $lowStockItems = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->whereColumn('quantity', '<=', 'minimum_stock_level')
            ->orderBy('quantity')
            ->limit(5)
            ->get();

        return view('pharmacy.dashboard', compact('stats', 'recentPrescriptions', 'lowStockItems'));
    }

    public function viewPrescriptions(Request $request)
    {
        $query = Prescription::with(['patient', 'prescribedBy', 'items.medication'])
            ->orderBy('prescription_date', 'desc');

        // Filter by Status
        if ($request->has('status') && in_array($request->status, ['pending', 'dispensed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prescription_number', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('card_number', 'like', "%{$search}%");
                  });
            });
        }
        
        // Date Filter
        if ($request->filled('date')) {
            $query->whereDate('prescription_date', $request->date);
        }

        $prescriptions = $query->paginate(20)->withQueryString();

        $counts = [
            'total' => Prescription::count(),
            'pending' => Prescription::where('status', 'pending')->count(),
            'dispensed' => Prescription::where('status', 'dispensed')->count(),
            'cancelled' => Prescription::where('status', 'cancelled')->count(),
        ];

        return view('pharmacy.view-prescriptions', compact('prescriptions', 'counts'));
    }

    public function viewPrescriptionDetails($id)
    {
        $prescription = Prescription::with(['patient', 'prescribedBy', 'items.medication'])
            ->findOrFail($id);
            
        return view('pharmacy.view-prescription-details', compact('prescription'));
    }

    public function dispenseMedications()
    {
        $prescriptions = Prescription::with(['patient', 'prescribedBy', 'items.medication'])
            ->whereIn('status', ['pending', 'partially_dispensed'])
            ->orderBy('prescription_date')
            ->get();

        return view('pharmacy.dispense-medications', compact('prescriptions'));
    }

    public function showDispenseForm($id)
    {
        $prescription = Prescription::with(['patient', 'prescribedBy', 'items.medication'])
            ->findOrFail($id);

        // Get stock information for each medication
        $medications = [];
        $colors = ['bg-blue-100', 'bg-green-100', 'bg-purple-100', 'bg-yellow-100', 'bg-pink-100'];
        $textColors = ['text-blue-600', 'text-green-600', 'text-purple-600', 'text-yellow-600', 'text-pink-600'];
        $colorIndex = 0;

        foreach ($prescription->items as $item) {
            $medication = $item->medication;
            
            // Get available inventory for this medication
            $inventory = Inventory::where('medication_id', $medication->id)
                ->where('location', 'pharmacy')
                ->where('quantity', '>', 0)
                ->orderBy('expiry_date')
                ->get();

            $totalStock = $inventory->sum('quantity');
            $batches = $inventory->map(function($inv) {
                return [
                    'number' => $inv->batch_number ?? 'N/A',
                    'expiry' => $inv->expiry_date ? $inv->expiry_date->format('Y-m-d') : 'N/A',
                    'quantity' => $inv->quantity,
                    'id' => $inv->id,
                ];
            })->toArray();

            $lowStock = $totalStock <= 10;
            $stockStatus = $totalStock > 20 ? 'Good' : ($totalStock > 10 ? 'Low' : 'Critical');

            $medications[] = [
                'id' => $item->id,
                'name' => $medication->name,
                'type' => $medication->dosage_form ?? 'N/A',
                'strength' => $medication->strength ?? 'N/A',
                'prescribed' => $item->quantity . ' ' . ($item->quantity > 1 ? 'units' : 'unit'),
                'available' => $totalStock,
                'dispense' => min($item->quantity, $totalStock),
                'stock' => $stockStatus,
                'lowStock' => $lowStock,
                'bgColor' => $colors[$colorIndex % count($colors)],
                'textColor' => $textColors[$colorIndex % count($textColors)],
                'batches' => $batches,
                'dosage' => $item->dosage,
                'frequency' => $item->frequency,
                'instructions' => $item->instructions,
            ];

            $colorIndex++;
        }

        // Get quick stock check for common medications
        $stockCheck = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->where('quantity', '>', 0)
            ->orderBy('quantity')
            ->limit(5)
            ->get()
            ->map(function($inv) {
                $stockClass = $inv->quantity > 20 ? 'text-green-600' : 
                             ($inv->quantity > 10 ? 'text-yellow-600' : 'text-red-600');
                $bgColor = $inv->quantity > 20 ? 'bg-green-100' : 
                          ($inv->quantity > 10 ? 'bg-yellow-100' : 'bg-red-100');
                $textColor = $inv->quantity > 20 ? 'text-green-600' : 
                            ($inv->quantity > 10 ? 'text-yellow-600' : 'text-red-600');

                return [
                    'name' => $inv->medication->name . ' ' . ($inv->medication->strength ?? ''),
                    'type' => $inv->medication->dosage_form ?? 'N/A',
                    'stock' => $inv->quantity,
                    'stockClass' => $stockClass,
                    'bgColor' => $bgColor,
                    'textColor' => $textColor,
                ];
            })->toArray();

        // Get patient allergies
        $allergies = $prescription->patient->allergies 
            ? explode(',', $prescription->patient->allergies) 
            : [];

        return view('pharmacy.dispense-medications', compact('prescription', 'medications', 'stockCheck', 'allergies'));
    }

    public function updateDispenseStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:prescription_items,id',
            'items.*.quantity' => 'required|integer|min:0',
            'items.*.batch_id' => 'nullable|exists:inventory,id',
            'items.*.status' => 'required|in:dispensed,out_of_stock,cancelled',
            'patient_instructions' => 'nullable|string',
            'pharmacy_notes' => 'nullable|string',
        ]);

        $prescription = Prescription::findOrFail($id);
        $allDispensed = true;
        $someDispensed = false;

        foreach ($validated['items'] as $itemData) {
            $item = PrescriptionItem::findOrFail($itemData['item_id']);
            
            if ($itemData['status'] === 'dispensed') {
                $quantityToDispense = $itemData['quantity'];
                
                // Update inventory if batch is specified
                if (!empty($itemData['batch_id'])) {
                    $inventory = Inventory::findOrFail($itemData['batch_id']);
                    
                    if ($inventory->quantity >= $quantityToDispense) {
                        $inventory->decrement('quantity', $quantityToDispense);
                        
                        // FR-20: Trigger Low Stock Alert
                        if ($inventory->quantity <= $inventory->minimum_stock_level) {
                            $pharmacists = User::where('role', 'Pharmacist')->get();
                            Notification::send($pharmacists, new LowStockAlert($inventory));
                        }
                        
                        $item->update(['status' => 'dispensed']);
                        $someDispensed = true;
                    } else {
                        $item->update(['status' => 'out_of_stock']);
                        $allDispensed = false;
                    }
                } else {
                    // Try to find available inventory
                    $inventory = Inventory::where('medication_id', $item->medication_id)
                        ->where('location', 'pharmacy')
                        ->where('quantity', '>', 0)
                        ->orderBy('expiry_date')
                        ->first();

                    if ($inventory && $inventory->quantity >= $quantityToDispense) {
                        $inventory->decrement('quantity', $quantityToDispense);
                        
                        // FR-20: Trigger Low Stock Alert
                        if ($inventory->quantity <= $inventory->minimum_stock_level) {
                            $pharmacists = User::where('role', 'Pharmacist')->get();
                            Notification::send($pharmacists, new LowStockAlert($inventory));
                        }

                        $item->update(['status' => 'dispensed']);
                        $someDispensed = true;
                    } else {
                        $item->update(['status' => 'out_of_stock']);
                        $allDispensed = false;
                    }
                }
            } else {
                $item->update(['status' => $itemData['status']]);
                if ($itemData['status'] === 'dispensed') {
                    $someDispensed = true;
                } else {
                    $allDispensed = false;
                }
            }
        }

        // Update prescription status
        if ($allDispensed && $someDispensed) {
            $prescription->update(['status' => 'dispensed']);
        } elseif ($someDispensed) {
            $prescription->update(['status' => 'partially_dispensed']);
        }

        return redirect()->route('pharmacy.dispense-medications')
            ->with('success', 'Medications dispensed successfully.');
    }

    public function inventoryManagement()
    {
        $inventory = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->orderBy('medication_id')
            ->orderBy('expiry_date')
            ->paginate(20);

        $medications = Medication::orderBy('name')->get();

        return view('pharmacy.inventory-management', compact('inventory', 'medications'));
    }

    public function storeInventory(Request $request)
    {
        // Check if adding a new medication or using existing one
        $isNewMedication = $request->input('medication_mode') === 'new';
        
        if ($isNewMedication) {
            // Validate new medication fields
            $request->validate([
                'new_medication_name' => 'required|string|max:255|unique:medications,name',
                'new_generic_name' => 'nullable|string|max:255',
                'new_dosage_form' => 'nullable|string|max:100',
                'new_strength' => 'nullable|string|max:100',
                'new_category' => 'nullable|string|max:100',
            ]);
            
            // Create the new medication
            $medication = Medication::create([
                'name' => $request->input('new_medication_name'),
                'generic_name' => $request->input('new_generic_name') ?? $request->input('new_medication_name'),
                'dosage_form' => $request->input('new_dosage_form'),
                'strength' => $request->input('new_strength'),
                'category' => $request->input('new_category'),
                'requires_prescription' => $request->has('new_requires_prescription'),
                'is_active' => true,
            ]);
            
            $medicationId = $medication->id;
        } else {
            // Validate existing medication selection
            $request->validate([
                'medication_id' => 'required|exists:medications,id',
            ]);
            
            $medicationId = $request->input('medication_id');
        }
        
        // Validate inventory fields
        $validated = $request->validate([
            'batch_number' => ['nullable', 'string', 'alpha_num'], // Alphanumeric Only
            'quantity' => 'required|integer|min:1', // Number Only
            'minimum_stock_level' => 'required|integer|min:0', // Number Only
            'expiry_date' => 'nullable|date',
            'unit_price' => ['nullable', 'numeric', 'min:0'], // Number/Decimal Only
            'supplier' => ['nullable', 'string', 'regex:/^[a-zA-Z0-9\s\.]+$/'], // Text/Number/Spaces
            'received_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['medication_id'] = $medicationId;
        $validated['location'] = 'pharmacy';

        Inventory::create($validated);

        $successMessage = $isNewMedication 
            ? 'New medication registered and added to inventory successfully.'
            : 'Inventory item added successfully.';

        return redirect()->route('pharmacy.inventory-management')
            ->with('success', $successMessage);
    }

    public function updateInventory(Request $request, $id)
    {
        $validated = $request->validate([
            'medication_id' => 'required|exists:medications,id',
            'batch_number' => ['nullable', 'string', 'alpha_num'],
            'quantity' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'supplier' => ['nullable', 'string', 'regex:/^[a-zA-Z0-9\s\.]+$/'],
            'received_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $item = Inventory::where('location', 'pharmacy')->findOrFail($id);
        $item->update($validated);

        // FR-20: Check logic for manual updates too
        if ($item->quantity <= $item->minimum_stock_level) {
            $pharmacists = User::where('role', 'Pharmacist')->get();
            Notification::send($pharmacists, new LowStockAlert($item));
        }

        return redirect()->route('pharmacy.inventory-management')
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroyInventory($id)
    {
        $item = Inventory::where('location', 'pharmacy')->findOrFail($id);
        $item->delete();

        return redirect()->route('pharmacy.inventory-management')
            ->with('success', 'Inventory item removed successfully.');
    }

    /**
     * Store a new medication in the database (Pharmacy registers medicines)
     */
    public function storeMedication(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:medications,name',
            'generic_name' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'dosage_form' => 'nullable|string|max:100',
            'strength' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'requires_prescription' => 'nullable|boolean',
        ]);

        $validated['is_active'] = true;
        $validated['requires_prescription'] = $request->has('requires_prescription');

        Medication::create($validated);

        return redirect()->route('pharmacy.inventory-management')
            ->with('success', 'New medication registered successfully. You can now add it to inventory.');
    }

    public function checkExpiry()
    {
        $expiringSoon = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->whereBetween('expiry_date', [now(), now()->addDays(30)])
            ->orderBy('expiry_date')
            ->get();

        $expired = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->where('expiry_date', '<', now())
            ->orderBy('expiry_date')
            ->get();

        return view('pharmacy.check-expiry', compact('expiringSoon', 'expired'));
    }

    public function generateReports(Request $request)
    {
        if ($request->has('export')) {
            $type = $request->get('export');
            $csvData = "";
            $filename = "";

            if ($type === 'inventory') {
                $data = Inventory::with('medication')->where('location', 'pharmacy')->get();
                $csvData = "ID,Medication,Batch,Quantity,Min Stock,Expiry Date,Supplier,Unit Price\n";
                foreach ($data as $row) {
                    $csvData .= "{$row->id},\"{$row->medication->name}\",{$row->batch_number},{$row->quantity},{$row->minimum_stock_level},{$row->expiry_date},\"{$row->supplier}\",{$row->unit_price}\n";
                }
                $filename = "inventory_report_" . date('Y-m-d') . ".csv";
            } elseif ($type === 'prescriptions') {
                $data = Prescription::with(['patient', 'prescribedBy'])->get();
                $csvData = "Prescription ID,Patient,Doctor,Date,Status,Notes\n";
                foreach ($data as $row) {
                    $csvData .= "{$row->prescription_number},\"{$row->patient->full_name}\",\"{$row->prescribedBy->name}\",{$row->prescription_date},{$row->status},\"{$row->notes}\"\n";
                }
                $filename = "prescriptions_report_" . date('Y-m-d') . ".csv";
            }

            if ($csvData) {
                return response($csvData)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
            }
        }
        
        return view('pharmacy.generate-reports');
    }

    /**
     * Export inventory as PDF
     */
    public function exportInventoryPDF()
    {
        $inventory = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->orderBy('medication_id')
            ->get()
            ->map(function($item) {
                return (object) [
                    'medication_name' => $item->medication->name ?? 'N/A',
                    'category' => $item->medication->category ?? 'N/A',
                    'stock' => $item->quantity,
                    'unit' => $item->medication->unit ?? 'units',
                    'reorder_level' => $item->minimum_stock_level,
                    'expiry_date' => $item->expiry_date,
                ];
            });
        
        $reportService = new ReportService();
        return $reportService->generatePDF(
            ['inventory' => $inventory],
            'reports.inventory-pdf',
            'pharmacy-inventory-' . now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Export inventory as Excel
     */
    public function exportInventoryExcel()
    {
        $inventory = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->orderBy('medication_id')
            ->get()
            ->map(function($item) {
                return (object) [
                    'medication_name' => $item->medication->name ?? 'N/A',
                    'category' => $item->medication->category ?? 'N/A',
                    'stock' => $item->quantity,
                    'unit' => $item->medication->unit ?? 'units',
                    'reorder_level' => $item->minimum_stock_level,
                    'expiry_date' => $item->expiry_date,
                ];
            });
        
        return Excel::download(
            new InventoryExport($inventory),
            'pharmacy-inventory-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export prescriptions as Excel
     */
    public function exportPrescriptionsExcel()
    {
        $prescriptions = Prescription::with(['patient', 'prescribedBy', 'items'])
            ->orderBy('prescription_date', 'desc')
            ->get();
        
        return Excel::download(
            new PrescriptionsExport($prescriptions),
            'pharmacy-prescriptions-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
