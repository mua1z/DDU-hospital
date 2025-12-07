<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                return view('dashboards.receptions');
            case 'doctors':
                return view('dashboards.doctors');
            case 'laboratory':
                return view('dashboards.laboratory');
            case 'pharmacist':
                return view('dashboards.pharmacist');
            default:
                return view('dashboards.user');
        }
    }
}
