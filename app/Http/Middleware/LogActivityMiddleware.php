<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log authenticated users or critical paths
        // Ideally we skip 'GET' requests to avoid noise, but user wants "whole system events"
        // Let's log non-read methods OR specific routes
        if ($request->method() !== 'GET' || $request->is('login*', 'logout*')) {
             \App\Models\SystemLog::create([
                'subject' => $this->resolveSubject($request),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'user_id' => auth()->id(),
            ]);
        }

        return $response;
    }

    private function resolveSubject(Request $request)
    {
        // Try to guess a human readable subject
        if ($request->is('login')) return 'User Login';
        if ($request->is('logout')) return 'User Logout';
        
        // Use Route Name if available for cleaner base
        $route = $request->route();
        $name = $route ? $route->getName() : null;
        
        if ($name) {
            // e.g. "admin.users.update" -> "Admin Users Update"
            $base = ucwords(str_replace(['.', '-', '_'], ' ', $name));
        } else {
            $base = ucwords(str_replace(['-', '/', '_', '.'], ' ', $request->path()));
            // Remove standalone numbers from path-based names
            $base = preg_replace('/\s+\d+\s*/', ' ', $base);
        }

        // Try to find entity names in parameters (Route Model Binding)
        $details = [];
        if ($route) {
            foreach ($route->parameters() as $key => $value) {
                if ($value instanceof \Illuminate\Database\Eloquent\Model) {
                    // Try common name fields in order of preference
                    $entityName = $value->full_name 
                                ?? $value->name 
                                ?? $value->dduc_id 
                                ?? $value->prescription_number 
                                ?? $value->card_number 
                                ?? $value->title 
                                ?? null;
                                
                    if ($entityName) {
                        $details[] = $entityName;
                    }
                }
            }
        }
        
        $action = $route ? $route->getActionMethod() : 'Action';
        
        if (!empty($details)) {
            return $base . ": " . implode(', ', $details);
        }

        return $base . " (" . $action . ")";
    }
}
