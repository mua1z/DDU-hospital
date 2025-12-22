<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // For demonstration, we'll pass some static settings
        // In a real app, these would come from the database
        $settings = [
            'app_name' => 'DDU Clinics',
            'maintenance_mode' => false,
            'allow_registration' => true,
            'email_notifications' => true,
            'system_timezone' => 'Africa/Addis_Ababa',
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // In a real implementation, you would save these to DB or .env
        // For this demo, we'll just redirect back with a success message
        return back()->with('status', 'Settings updated successfully (Demo Mode).');
    }
}
