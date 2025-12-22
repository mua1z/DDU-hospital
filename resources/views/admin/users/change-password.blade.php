@extends('admin.layouts.layout')

@section('title', 'Change Password - Admin Dashboard')

@section('content')
<div class="max-w-xl mx-auto animate-slide-up">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Change Password</h2>
        <a href="{{ route('admin.users.index') }}" class="text-purple-600 hover:underline font-medium flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <p class="text-gray-600 text-sm">Changing password for user: <span class="font-bold text-gray-800">{{ $user->name }}</span> ({{ $user->dduc_id }})</p>
        </div>

        <form method="POST" action="{{ route('admin.users.change-password', $user) }}">
            @csrf

            <!-- New Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input id="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition" 
                       type="password" name="password" required autocomplete="new-password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-8">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                <input id="password_confirmation" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition" 
                       type="password" name="password_confirmation" required>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.users.index') }}" class="mr-4 text-gray-600 hover:text-gray-800 text-sm font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
