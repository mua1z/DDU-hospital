@extends('admin.layouts.layout')

@section('title', 'System Logs - Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto animate-slide-up">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">System Activity Logs</h2>
            <p class="text-gray-500 text-sm">Monitor user activities and system events (Database)</p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            <form method="GET" class="flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search action or IP..." class="border border-gray-300 rounded-l-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button type="submit" class="bg-gray-100 border border-gray-300 border-l-0 rounded-r-lg px-4 text-gray-600 hover:bg-gray-200">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a href="{{ route('admin.logs.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg shadow-sm transition flex items-center">
                <i class="fas fa-sync-alt mr-2 text-gray-500"></i> Refresh
            </a>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-semibold">
                        <th class="px-6 py-4">Time</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Action (Subject)</th>
                        <th class="px-6 py-4">Method / URL</th>
                        <th class="px-6 py-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                {{ $log->created_at->format('M d, H:i:s') }}
                                <span class="text-xs block text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->user)
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs mr-2">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $log->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $log->user->dduc_id }} ({{ $log->user->role }})</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs mr-2">
                                            <i class="fas fa-robot"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">System / Guest</div>
                                            <div class="text-xs text-gray-400">Automated or Unauthenticated</div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-700">{{ $log->subject }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="px-2 py-0.5 rounded text-xs font-bold mr-2
                                        {{ $log->method === 'POST' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $log->method === 'PUT' || $log->method === 'PATCH' ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $log->method === 'DELETE' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $log->method === 'GET' ? 'bg-green-100 text-green-700' : '' }}
                                    ">
                                        {{ $log->method }}
                                    </span>
                                    <span class="text-gray-500 truncate max-w-xs" title="{{ $log->url }}">{{ Str::limit($log->url, 40) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                                {{ $log->ip }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-history text-gray-400 text-xl"></i>
                                    </div>
                                    <p>No system activity logs found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #1f2937; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4b5563; 
        border-radius: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #6b7280; 
    }
</style>
@endsection
