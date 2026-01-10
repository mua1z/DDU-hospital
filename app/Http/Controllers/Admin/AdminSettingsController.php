<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // Fetch all settings and map to key-value array
        $settingsDB = Setting::all()->pluck('value', 'key')->toArray();
        
        // Default values if DB is empty
        $defaults = [
            'app_name' => 'DDU Clinics',
            'hospital_email' => 'admin@ddu.edu.et',
            'hospital_phone' => '+251 123 456 789',
            'maintenance_mode' => '0',
            'allow_registration' => '1',
            'system_timezone' => 'Africa/Addis_Ababa',
        ];

        $settings = array_merge($defaults, $settingsDB);
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'hospital_email' => 'required|email',
            'hospital_phone' => 'required|string',
            'system_timezone' => 'required|string',
        ]);

        // Save validated fields
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle checkbox/boolean fields explicitly
        $booleans = ['maintenance_mode', 'allow_registration'];
        foreach ($booleans as $key) {
            $value = $request->has($key) ? '1' : '0';
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'System settings updated successfully.');
    }
}
