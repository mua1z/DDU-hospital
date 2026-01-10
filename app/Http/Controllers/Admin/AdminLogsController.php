<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class AdminLogsController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemLog::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                 $q->where('subject', 'like', "%$search%")
                   ->orWhere('ip', 'like', "%$search%");
            });
        }

        $logs = $query->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
