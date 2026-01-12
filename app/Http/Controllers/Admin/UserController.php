<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ReportService;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

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
            'name' => ['required','string','max:255', 'regex:/^[a-zA-Z\s\.]+$/'], // Name text only
            'dduc_id' => ['required','string','max:255','alpha_num','unique:users,dduc_id'], // Alphanumeric
            'password' => ['required','confirmed','min:8'],
            'role' => ['required','in:Admin,Receptions,Doctors,Laboratory,Pharmacist,User,Patient'],
            'room_number' => ['nullable', 'string', 'max:20'], // Room number for doctors
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
            'room_number' => $data['room_number'] ?? null,
            'is_active' => $request->boolean('is_active', false),
        ]);

        // If keeping role as Patient, ensure Patient record exists
        if (strcasecmp($data['role'], 'Patient') === 0) {
            $cardNumber = str_ireplace('DDUC', '', $dduc); // Remove DDUC prefix
            // Create stub patient record
            \App\Models\Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $user->name,
                    'card_number' => $cardNumber,
                    'is_active' => $user->is_active,
                    // DOB and Gender are nullable now, so safe to omit
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('status', 'User created');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255', 'regex:/^[a-zA-Z\s\.]+$/'], // Name text only
            'dduc_id' => ['required','string','max:255','alpha_num','unique:users,dduc_id,'.$user->id], // Alphanumeric
            'role' => ['required','in:Admin,Receptions,Doctors,Laboratory,Pharmacist,User,Patient'],
            'room_number' => ['nullable', 'string', 'max:20'], // Room number for doctors
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
            'room_number' => $data['room_number'] ?? null,
            'is_active' => $request->boolean('is_active', false),
        ]);

        // If updated to Patient, ensure Patient record exists
        if (strcasecmp($data['role'], 'Patient') === 0) {
            $cardNumber = str_ireplace('DDUC', '', $dduc);
            \App\Models\Patient::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $user->name,
                    'card_number' => $cardNumber,
                    'is_active' => $user->is_active,
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('status', 'User updated');
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('status', 'You cannot delete your own admin account');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('status', 'User deleted successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for foreign key constraint violation code
            if ($e->getCode() == 23000) {
                return redirect()->route('admin.users.index')->with('error', 'Cannot delete user: This user is referenced in other records (e.g. appointments, prescriptions).');
            }
            return redirect()->route('admin.users.index')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
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

    /**
     * Export users as PDF
     */
    public function exportPDF()
    {
        $users = User::orderBy('id', 'desc')->get();
        
        $reportService = new ReportService();
        return $reportService->generatePDF(
            ['users' => $users],
            'reports.users-pdf',
            'users-report-' . now()->format('Y-m-d') . '.pdf'
        );
    }

    /**
     * Export users as Excel
     */
    public function exportExcel()
    {
        $users = User::orderBy('id', 'desc')->get();
        
        return Excel::download(
            new UsersExport($users),
            'users-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
