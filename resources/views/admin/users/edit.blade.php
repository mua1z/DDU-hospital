@extends('admin.layouts.layout')

@section('title', 'Edit User - Admin Dashboard')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-up">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
        <a href="{{ route('admin.users.index') }}" class="text-purple-600 hover:underline font-medium flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <!-- DDUC ID (Read-only) -->
            <div class="mb-6">
                <label for="dduc_id" class="block text-sm font-medium text-gray-700 mb-2">DDUC ID</label>
                <input id="dduc_id" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed focus:outline-none" 
                       type="text" name="dduc_id" value="{{ $user->dduc_id }}" readonly>
                <p class="text-xs text-gray-500 mt-1">DDUC ID cannot be changed.</p>
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input id="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition" 
                       type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>



            <!-- Role -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select id="role" name="role" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition bg-white">
                    @foreach(['User', 'Admin', 'Receptions', 'Doctors', 'Laboratory', 'Pharmacist'] as $role)
                        <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-8">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} 
                           class="w-5 h-5 text-purple-600 rounded border-gray-300 focus:ring-purple-500 focus:ring-2">
                    <span class="text-gray-700 font-medium select-none">Account is Active</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.users.index') }}" class="mr-4 text-gray-600 hover:text-gray-800 text-sm font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
