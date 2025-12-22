@extends('admin.layouts.layout')

@section('title', 'Manage Users - Admin Dashboard')

@section('content')
<div class="animate-slide-up">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
            <p class="text-gray-500 text-sm">Create, edit, and manage system users</p>
        </div>
        
        <a href="{{ route('admin.users.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="fas fa-user-plus mr-2"></i> Create User
        </a>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('status') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">DDUC ID</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 text-sm text-gray-600">#{{ $u->id }}</td>
                        <td class="py-4 px-6">
                            <span class="font-medium text-gray-800">{{ $u->dduc_id }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3 text-purple-600 font-bold text-xs">
                                    {{ substr($u->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $roleColors = [
                                    'Admin' => 'bg-purple-100 text-purple-800',
                                    'Doctors' => 'bg-green-100 text-green-800',
                                    'Receptions' => 'bg-blue-100 text-blue-800',
                                    'Laboratory' => 'bg-indigo-100 text-indigo-800',
                                    'Pharmacist' => 'bg-red-100 text-red-800',
                                    'User' => 'bg-gray-100 text-gray-800'
                                ];
                                $colorClass = $roleColors[$u->role] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                                {{ $u->role }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($u->is_active)
                                <span class="flex items-center text-green-600 text-xs font-medium">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Active
                                </span>
                            @else
                                <span class="flex items-center text-red-600 text-xs font-medium">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.users.change-password.form', $u) }}" class="text-yellow-500 hover:text-yellow-700 transition" title="Change Password">
                                <i class="fas fa-key"></i>
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
