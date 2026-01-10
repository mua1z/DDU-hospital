<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
             abort(403, 'Unauthorized.');
        }

        // Normalize user role and expected role
        $userRole = strtolower($user->role);
        $expectedRole = strtolower($role);

        // Define role mappings (Route Param -> Possible DB Values)
        $roleMappings = [
            'doctor' => ['doctor', 'doctors'],
            'receptionist' => ['reception', 'receptions', 'receptionist'],
            'lab_technician' => ['laboratory', 'lab technician', 'lab'],
            'pharmacist' => ['pharmacist', 'pharmacy'],
            'patient' => ['patient', 'user'],
            'admin' => ['admin'],
        ];

        // Check if the user's role matches any of the allowed values for the expected role
        $allowedRoles = $roleMappings[$expectedRole] ?? [$expectedRole];
        
        if (!in_array($userRole, $allowedRoles)) {
             abort(403, "Unauthorized. User role '{$user->role}' does not match required role '{$role}'.");
        }

        return $next($request);
    }
}
