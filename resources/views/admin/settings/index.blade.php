@extends('admin.layouts.layout')

@section('title', 'System Settings - Admin Dashboard')

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">System Settings</h2>
            <p class="text-gray-500 text-sm">Manage application configuration</p>
        </div>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('status') }}</p>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Settings Navigation -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <nav class="flex flex-col">
                    <a href="#" class="px-4 py-3 bg-purple-50 text-purple-700 font-medium border-l-4 border-purple-600 flex items-center">
                        <i class="fas fa-cogs w-6"></i> General
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">General Configuration</h3>
                
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    
                    <!-- App Name -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Application Name</label>
                        <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'DDU Clinics' }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition" required>
                    </div>

                    <!-- Hospital Email -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hospital Contact Email</label>
                        <input type="email" name="hospital_email" value="{{ $settings['hospital_email'] ?? '' }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition" required>
                    </div>

                    <!-- Hospital Phone -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hospital Contact Phone</label>
                        <input type="text" name="hospital_phone" value="{{ $settings['hospital_phone'] ?? '' }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition" required>
                    </div>

                    <!-- Timezone -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">System Timezone</label>
                        <select name="system_timezone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition bg-white">
                            <option value="UTC" {{ ($settings['system_timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                            <option value="Africa/Addis_Ababa" {{ ($settings['system_timezone'] ?? '') == 'Africa/Addis_Ababa' ? 'selected' : '' }}>Africa/Addis_Ababa</option>
                            <option value="America/New_York" {{ ($settings['system_timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                            <option value="Europe/London" {{ ($settings['system_timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                        </select>
                    </div>

                    <!-- Toggles -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-800">Maintenance Mode</h4>
                                <p class="text-xs text-gray-500">Put the site offline for visitors</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-800">Allow Registration</h4>
                                <p class="text-xs text-gray-500">Allow new users to register</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="allow_registration" value="1" class="sr-only peer" {{ ($settings['allow_registration'] ?? true) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
