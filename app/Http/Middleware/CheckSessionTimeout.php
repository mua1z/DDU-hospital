<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Get session lifetime from config (in minutes)
            $lifetime = config('session.lifetime');
            
            // Get last activity time from session
            $lastActivity = $request->session()->get('last_activity_time');
            
            // If last activity exists, check if session has expired
            if ($lastActivity) {
                $inactiveMinutes = (time() - $lastActivity) / 60;
                
                // If inactive time exceeds session lifetime, logout user
                if ($inactiveMinutes > $lifetime) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return redirect()->route('login')
                        ->with('message', 'Your session has expired due to inactivity. Please login again.');
                }
            }
            
            // Update last activity time
            $request->session()->put('last_activity_time', time());
        }
        
        return $next($request);
    }
}
