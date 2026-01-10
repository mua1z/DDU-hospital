<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // This endpoint should be protected for Admin use only.
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'], // Text only (letters, spaces, dots)
            'dduc_id' => ['required', 'string', 'max:255', 'alpha_num', 'unique:users,dduc_id'], // Alphanumeric
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['sometimes', 'string', 'in:User,Admin,Receptions,Doctors,Laboratory,Pharmacist'],
        ]);

        $dduc = strtoupper($request->dduc_id);
        if (! str_starts_with($dduc, 'DDUC')) {
            $dduc = 'DDUC'.$dduc;
        }

        $user = User::create([
            'name' => $request->name,
            'dduc_id' => $dduc,
            'password' => Hash::make($request->password),
            'role' => $request->input('role', 'User'),
            'is_active' => $request->boolean('is_active', false),
        ]);

        // Do not auto-login. Admin will provide credentials to user.
        event(new Registered($user));

        return redirect()->back()->with('status', 'User created. Provide DDUC ID and password to the user when ready.');
    }
}
