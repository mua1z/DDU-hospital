@extends('admin.layouts.layout')

@section('title', 'System Logs - Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto animate-slide-up">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">System Logs</h2>
            <p class="text-gray-500 text-sm">View recent application logs (Laravel.log)</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="location.reload()" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg shadow-sm transition flex items-center">
                <i class="fas fa-sync-alt mr-2 text-gray-500"></i> Refresh
            </button>
            <button class="bg-red-50 border border-red-200 text-red-700 hover:bg-red-100 px-4 py-2 rounded-lg shadow-sm transition flex items-center opacity-50 cursor-not-allowed" title="Not implemented in demo">
                <i class="fas fa-trash-alt mr-2"></i> Clear Logs
            </button>
        </div>
    </div>

    <!-- Logs Viewer -->
    <div class="bg-gray-900 rounded-xl shadow-lg border border-gray-800 overflow-hidden text-gray-300 font-mono text-xs md:text-sm">
        <div class="bg-gray-800 px-4 py-3 border-b border-gray-700 flex justify-between items-center">
            <span class="font-semibold text-gray-400">storage/logs/laravel.log (Last 100 lines)</span>
            <div class="flex space-x-2">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
            </div>
        </div>
        
        <div class="p-4 overflow-x-auto h-[600px] overflow-y-auto custom-scrollbar">
            <table class="w-full">
                <tbody>
                    @forelse($logs as $index => $log)
                        @php
                            $rowClass = $index % 2 == 0 ? 'bg-gray-900' : 'bg-gray-800/30';
                            $levelColor = match(strtoupper($log['level'])) {
                                'ERROR' => 'text-red-400',
                                'CRITICAL' => 'text-red-500 font-bold',
                                'WARNING' => 'text-yellow-400',
                                'INFO' => 'text-blue-400',
                                'DEBUG' => 'text-green-400',
                                default => 'text-gray-400'
                            };
                        @endphp
                        <tr class="hover:bg-gray-800 transition">
                            <td class="align-top py-1 pr-4 text-gray-600 select-none text-right w-12">{{ $index + 1 }}</td>
                            <td class="align-top py-1 pr-4 text-gray-500 whitespace-nowrap">[{{ $log['timestamp'] }}]</td>
                            <td class="align-top py-1 pr-4 {{ $levelColor }} font-bold whitespace-nowrap">{{ $log['level'] }}</td>
                            <td class="align-top py-1 text-gray-300 break-all">{{ $log['message'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                <i class="fas fa-check-circle text-4xl mb-3 text-green-500"></i>
                                <p>Log file is empty or missing.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
