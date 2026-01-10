@extends('admin.layouts.layout')

@section('title', 'Create User - Admin Dashboard')

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    <!-- Header Navigation -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Create User</h2>
            <p class="text-gray-500 mt-1">Add a new staff member to the hospital system</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-2 bg-white text-gray-600 rounded-lg shadow-sm border border-gray-200 hover:bg-purple-50 hover:text-purple-600 transition">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> 
            <span class="font-medium">Back to List</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 relative">
        <!-- Decorative Top Line -->
        <div class="h-2 bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-500 w-full absolute top-0"></div>

        <div class="flex flex-col md:flex-row">
            <!-- Sidebar / Info Panel (Desktop) -->
            <div class="hidden md:block w-1/3 bg-gray-50 p-8 border-r border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i> Quick Tips
                </h3>
                <ul class="space-y-4 text-sm text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i>
                        <span><strong>DDUC ID</strong> must be unique. The system will auto-prefix "DDUC" if you omit it.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i>
                        <span><strong>Roles</strong> determine what dashboard the user sees (e.g., Doctor dashboard).</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i>
                        <span><strong>Passwords</strong> must be at least 8 characters long.</span>
                    </li>
                </ul>

                <div class="mt-8 p-4 bg-purple-100 rounded-xl border border-purple-200">
                    <h4 class="text-purple-800 font-bold text-sm mb-1">Need Help?</h4>
                    <p class="text-purple-600 text-xs">Contact the IT department if you are unsure about the role assignment.</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="w-full md:w-2/3 p-8">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <!-- Section: Identity -->
                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                            <i class="fas fa-id-card mr-1"></i> User Identity
                        </h3>
                        <div class="grid grid-cols-1 gap-6">
                            <!-- DDUC ID -->
                            <div class="relative group">
                                <label for="dduc_id" class="block text-sm font-medium text-gray-700 mb-1 pointer-events-none">DDUC ID</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-hashtag text-gray-400 group-focus-within:text-purple-500 transition"></i>
                                    </div>
                                    <input id="dduc_id" type="text" name="dduc_id" value="{{ old('dduc_id') }}" required autofocus autocomplete="off"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition duration-200"
                                           placeholder="e.g. 250100">
                                </div>
                                @error('dduc_id')
                                    <p class="text-red-500 text-xs mt-1 flex items-center animate-pulse"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="relative group">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1 pointer-events-none">Full Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400 group-focus-within:text-purple-500 transition"></i>
                                    </div>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition duration-200"
                                           placeholder="e.g. Dr. Sarah Smith">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1 flex items-center animate-pulse"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Access -->
                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                            <i class="fas fa-lock mr-1"></i> Access & Security
                        </h3>
                        
                        <!-- Role -->
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">System Role</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tag text-gray-400"></i>
                                </div>
                                <select id="role" name="role" class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition appearance-none cursor-pointer">
                                    <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User (Standard)</option>
                                    <option value="Doctors" {{ old('role') == 'Doctors' ? 'selected' : '' }}>Doctor</option>
                                    <option value="Receptions" {{ old('role') == 'Receptions' ? 'selected' : '' }}>Receptionist</option>
                                    <option value="Laboratory" {{ old('role') == 'Laboratory' ? 'selected' : '' }}>Lab Technician</option>
                                    <option value="Pharmacist" {{ old('role') == 'Pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Administrator</option>
                                    <option value="Patient" {{ old('role') == 'Patient' ? 'selected' : '' }}>Patient</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div class="relative group">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-key text-gray-400 group-focus-within:text-purple-500 transition"></i>
                                    </div>
                                    <input id="password" type="password" name="password" required autocomplete="new-password"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition duration-200"
                                           placeholder="••••••••">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 flex items-center animate-pulse"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="relative group">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-check-double text-gray-400 group-focus-within:text-purple-500 transition"></i>
                                    </div>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 outline-none transition duration-200"
                                           placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Toggle (Optional, can default to true) -->
                    <div class="mb-8 flex items-center bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <label class="relative inline-flex items-center cursor-pointer mr-4">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                        <div>
                            <span class="text-sm font-medium text-gray-900">Activate Account Immediately</span>
                            <p class="text-xs text-gray-500">User will be able to login right away.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-lg text-gray-600 font-medium hover:bg-gray-100 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold shadow-lg shadow-purple-200 transform hover:-translate-y-0.5 transition duration-200 flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
