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
                return view('dashboards.admin');
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
