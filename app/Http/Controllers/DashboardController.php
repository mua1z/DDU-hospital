<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Reception\ReceptionController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Lab\LabController;
use App\Http\Controllers\Pharmacy\PharmacyController;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->role ?? 'User';

        switch (strtolower($role)) {
            case 'admin':
                $stats = [
                    'total_users' => \App\Models\User::count(),
                    'doctors' => \App\Models\User::where('role', 'Doctors')->count(),
                    'lab' => \App\Models\User::where('role', 'Laboratory')->count(),
                    'pharmacy' => \App\Models\User::where('role', 'Pharmacist')->count(),
                    'reception' => \App\Models\User::where('role', 'Receptions')->count(),
                ];
                $recent_users = \App\Models\User::latest()->take(5)->get();
                return view('dashboards.admin', compact('stats', 'recent_users'));
            case 'receptions':
                $receptionController = new ReceptionController();
                return $receptionController->dashboard();
            case 'doctors':
                $doctorController = new DoctorController();
                return $doctorController->dashboard();
            case 'laboratory':
                $labController = new LabController();
                return $labController->dashboard();
            case 'pharmacist':
                $pharmacyController = new PharmacyController();
                return $pharmacyController->dashboard();
            default:
                return view('dashboards.user');
        }
    }
}
