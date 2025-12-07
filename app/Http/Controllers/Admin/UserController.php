<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'dduc_id' => ['required','string','max:255','unique:users,dduc_id'],
            'password' => ['required','confirmed','min:8'],
            'role' => ['required','in:Admin,Receptions,Doctors,Laboratory,Pharmacist,User'],
            'is_active' => ['sometimes','boolean'],
        ]);

        $dduc = strtoupper($data['dduc_id']);
        if (! str_starts_with($dduc, 'DDUC')) {
            $dduc = 'DDUC'.$dduc;
        }

        $user = User::create([
            'name' => $data['name'],
            'dduc_id' => $dduc,
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User created');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'dduc_id' => ['required','string','max:255','unique:users,dduc_id,'.$user->id],
            'role' => ['required','in:Admin,Receptions,Doctors,Laboratory,Pharmacist,User'],
            'is_active' => ['sometimes','boolean'],
        ]);

        $dduc = strtoupper($data['dduc_id']);
        if (! str_starts_with($dduc, 'DDUC')) {
            $dduc = 'DDUC'.$dduc;
        }

        $user->update([
            'name' => $data['name'],
            'dduc_id' => $dduc,
            'role' => $data['role'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User updated');
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('status', 'You cannot delete your own admin account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted');
    }

    // Reset password to a temporary value and return it for admin to give to user
    public function resetPassword(User $user)
    {
        // Keep for backward compatibility: redirect to change password form
        return redirect()->route('admin.users.change-password.form', $user->id);
    }

    public function showChangePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    public function changePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Password updated for '.$user->dduc_id);
    }
}
