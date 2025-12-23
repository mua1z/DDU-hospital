@extends('admin.layouts.layout')

@section('title', __('Admin Dashboard - DDU Clinics'))

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-slide-up">
    <!-- Users Card -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">{{ __('Total Users') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</h3>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg text-purple-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <a href="{{ route('admin.users.index') }}" class="text-purple-600 hover:text-purple-700 font-medium flex items-center">
                {{ __('View All Users') }} <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Doctors Card -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">{{ __('Total Doctors') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['doctors'] }}</h3>
            </div>
            <div class="p-3 bg-green-100 rounded-lg text-green-600">
                <i class="fas fa-user-md text-xl"></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-green-600">
            <span class="flex items-center"><i class="fas fa-check-circle mr-1"></i> {{ __('Active Staff') }}</span>
        </div>
    </div>

    <!-- Lab Card -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">{{ __('Lab Technicians') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['lab'] }}</h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                <i class="fas fa-flask text-xl"></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            {{ __('Pathology Dept') }}
        </div>
    </div>

    <!-- Pharmacists Card -->
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">{{ __('Pharmacists') }}</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['pharmacy'] }}</h3>
            </div>
            <div class="p-3 bg-red-100 rounded-lg text-red-600">
                <i class="fas fa-pills text-xl"></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
            {{ __('Pharmacy Dept') }}
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-8 animate-slide-up" style="animation-delay: 0.1s">
    <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('Quick Actions') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.users.create') }}" class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer group">
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center group-hover:bg-purple-600 transition">
                <i class="fas fa-user-plus text-purple-600 group-hover:text-white text-xl transition"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ __('Add New User') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('Create a new system account') }}</p>
            </div>
        </a>
        
        <a href="{{ route('admin.logs.index') }}" class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer group">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center group-hover:bg-blue-600 transition">
                <i class="fas fa-file-alt text-blue-600 group-hover:text-white text-xl transition"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ __('System Logs') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('View recent system activity') }}</p>
            </div>
        </a>
        
        <a href="{{ route('admin.settings.index') }}" class="bg-white rounded-xl shadow p-6 flex items-center space-x-4 hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer group">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center group-hover:bg-orange-600 transition">
                <i class="fas fa-cogs text-orange-600 group-hover:text-white text-xl transition"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ __('System Settings') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('Manage configuration') }}</p>
            </div>
        </a>
    </div>
</div>

<!-- Recent Activity Placeholder -->
<div class="animate-slide-up" style="animation-delay: 0.2s">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">{{ __('Recently Added Users') }}</h2>
        <a href="{{ route('admin.users.index') }}" class="text-purple-600 hover:underline font-medium">{{ __('View All') }}</a>
    </div>
    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">{{ __('Activity') }}</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">{{ __('User Name') }}</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">{{ __('Role') }}</th>
                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">{{ __('Joined') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_users as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-4 px-4"><span class="flex items-center text-gray-600"><i class="fas fa-user-plus text-purple-500 mr-2"></i> {{ __('New Account Created') }}</span></td>
                        <td class="py-4 px-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="py-4 px-4">
                            @php
                                $roleColors = [
                                    'Admin' => 'bg-purple-100 text-purple-800',
                                    'Doctors' => 'bg-green-100 text-green-800',
                                    'Receptions' => 'bg-blue-100 text-blue-800',
                                    'Laboratory' => 'bg-indigo-100 text-indigo-800',
                                    'Pharmacist' => 'bg-red-100 text-red-800',
                                    'User' => 'bg-gray-100 text-gray-800'
                                ];
                                $colorClass = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-gray-500">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">{{ __('No recent activity found.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
