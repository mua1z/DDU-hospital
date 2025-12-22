<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AdminLogsController extends Controller
{
    public function index()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            $file = File::get($logPath);
            // Get last 100 lines for performance
            $lines = array_slice(file($logPath), -100);
            $lines = array_reverse($lines); // Show newest first
            
            foreach ($lines as $line) {
                // Parse log line (Basic parsing)
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)/', $line, $matches)) {
                    $logs[] = [
                        'timestamp' => $matches[1],
                        'env' => $matches[2],
                        'level' => $matches[3],
                        'message' => $matches[4],
                        'raw' => $line
                    ];
                } else {
                    // If parsing fails, just add as raw message or skip empty lines
                    if (trim($line) !== '') {
                        $logs[] = [
                            'timestamp' => 'Unknown',
                            'env' => 'N/A',
                            'level' => 'INFO', // Default
                            'message' => $line,
                            'raw' => $line
                        ];
                    }
                }
            }
        }

        return view('admin.logs.index', compact('logs'));
    }
}
