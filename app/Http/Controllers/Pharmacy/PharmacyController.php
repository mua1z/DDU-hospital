<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Medication;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $query = Prescription::with(['patient', 'prescribedBy', 'items.medication']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Search by prescription number or patient name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prescription_number', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($patientQuery) use ($search) {
                      $patientQuery->where('full_name', 'like', "%{$search}%")
                                   ->orWhere('card_number', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by date if provided
        if ($request->has('date') && $request->date) {
            $query->whereDate('prescription_date', $request->date);
        }
        
        $prescriptions = $query->orderBy('prescription_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'total' => Prescription::count(),
            'pending' => Prescription::where('status', 'pending')->count(),
            'dispensed' => Prescription::where('status', 'dispensed')->count(),
            'completed' => Prescription::where('status', 'completed')->count(),
            'cancelled' => Prescription::where('status', 'cancelled')->count(),
        ];

        return view('pharmacy.view-prescriptions', compact('prescriptions', 'counts'));
    }

    public function dispenseMedications()
    {
        // Show prescriptions that are pending (sent from doctor) or partially dispensed
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
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.batch_id' => 'nullable|exists:inventory,id',
            'items.*.status' => 'required|in:dispensed,out_of_stock,cancelled',
            'patient_instructions' => 'nullable|string',
            'pharmacy_notes' => 'nullable|string',
        ]);

        $prescription = Prescription::with('items')->findOrFail($id);
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
                        $item->update(['status' => 'dispensed']);
                        $someDispensed = true;
                    } else {
                        $item->update(['status' => 'out_of_stock']);
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
                        $item->update(['status' => 'dispensed']);
                        $someDispensed = true;
                    } else {
                        $item->update(['status' => 'out_of_stock']);
                    }
                }
            } else {
                $item->update(['status' => $itemData['status']]);
                if ($itemData['status'] === 'dispensed') {
                    $someDispensed = true;
                }
            }
        }

        // Refresh prescription to get updated items
        $prescription->refresh();
        
        // Check if all items are dispensed
        $allItemsDispensed = $prescription->items->every(function ($item) {
            return $item->status === 'dispensed';
        });

        // Update prescription status
        if ($allItemsDispensed && $prescription->items->isNotEmpty()) {
            // All items dispensed - mark as completed (workflow finished)
            $prescription->update(['status' => 'completed']);
        } elseif ($someDispensed) {
            // Some items dispensed - mark as partially dispensed
            $prescription->update(['status' => 'partially_dispensed']);
        }

        return redirect()->route('pharmacy.dispense-medications')
            ->with('success', 'Medications dispensed successfully. Prescription marked as completed.');
    }

    public function inventoryManagement()
    {
        $inventory = Inventory::with('medication')
            ->where('location', 'pharmacy')
            ->orderBy('medication_id')
            ->orderBy('expiry_date')
            ->paginate(20);

        $medications = Medication::where('is_active', true)->orderBy('name')->get();

        return view('pharmacy.inventory-management', compact('inventory', 'medications'));
    }

    public function storeInventory(Request $request)
    {
        $validated = $request->validate([
            'medication_id' => 'required|exists:medications,id',
            'batch_number' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'minimum_stock_level' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'unit_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string',
            'received_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['location'] = 'pharmacy';

        Inventory::create($validated);

        return redirect()->route('pharmacy.inventory-management')
            ->with('success', 'Inventory item added successfully.');
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

    public function generateReports()
    {
        // Placeholder for report generation
        return view('pharmacy.generate-reports');
    }
}
