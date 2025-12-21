<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', EnsureAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}/change-password', [AdminUserController::class, 'showChangePassword'])->name('users.change-password.form');
    Route::post('users/{user}/change-password', [AdminUserController::class, 'changePassword'])->name('users.change-password');
    Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Reception Routes
use App\Http\Controllers\Reception\ReceptionController;
Route::middleware(['auth'])->prefix('reception')->name('reception.')->group(function () {
    Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('dashboard');
    Route::get('/register-patient', [ReceptionController::class, 'registerPatient'])->name('register-patient');
    Route::post('/register-patient', [ReceptionController::class, 'storePatient'])->name('store-patient');
    Route::get('/search-patients', [ReceptionController::class, 'searchPatients'])->name('search-patients');
    Route::get('/view-patient/{id}', [ReceptionController::class, 'viewPatient'])->name('view-patient');
    Route::get('/schedule-appointments', [ReceptionController::class, 'scheduleAppointments'])->name('schedule-appointments');
    Route::post('/schedule-appointments', [ReceptionController::class, 'storeAppointment'])->name('store-appointment');
    Route::get('/manage-walkin', [ReceptionController::class, 'manageWalkin'])->name('manage-walkin');
});

// Doctor Routes
use App\Http\Controllers\Doctor\DoctorController;
Route::middleware(['auth'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/view-appointments', [DoctorController::class, 'viewAppointments'])->name('view-appointments');
    Route::get('/request-lab-test', [DoctorController::class, 'requestLabTest'])->name('request-lab-test');
    Route::post('/request-lab-test', [DoctorController::class, 'storeLabRequest'])->name('store-lab-request');
    Route::get('/view-lab-results', [DoctorController::class, 'viewLabResults'])->name('view-lab-results');
    Route::get('/write-prescription', [DoctorController::class, 'writePrescription'])->name('write-prescription');
    Route::post('/write-prescription', [DoctorController::class, 'storePrescription'])->name('store-prescription');
    Route::get('/document-history', [DoctorController::class, 'documentHistory'])->name('document-history');
    Route::post('/appointments/{appointment}/consult', [DoctorController::class, 'consultAppointment'])->name('appointments.consult');
});

// Lab Routes
use App\Http\Controllers\Lab\LabController;
Route::middleware(['auth'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/dashboard', [LabController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending-requests', [LabController::class, 'pendingRequests'])->name('pending-requests');
    Route::get('/process-test', function() { return redirect()->route('lab.pending-requests'); })->name('process-test');
    Route::get('/process-test/{id}', [LabController::class, 'processTest'])->name('process-test-id');
    Route::post('/process-test/{id}', [LabController::class, 'updateRequestStatus'])->name('update-request-status');
    Route::get('/upload-results', [LabController::class, 'uploadResults'])->name('upload-results');
    Route::post('/upload-results', [LabController::class, 'storeResults'])->name('store-results');
    Route::get('/test-results', [LabController::class, 'testResults'])->name('test-results');
    Route::get('/inventory', [LabController::class, 'inventory'])->name('inventory');
    Route::get('/quality-control', [LabController::class, 'qualityControl'])->name('quality-control');
});

// Pharmacy Routes
use App\Http\Controllers\Pharmacy\PharmacyController;
Route::middleware(['auth'])->prefix('pharmacy')->name('pharmacy.')->group(function () {
    Route::get('/dashboard', [PharmacyController::class, 'dashboard'])->name('dashboard');
    Route::get('/view-prescriptions', [PharmacyController::class, 'viewPrescriptions'])->name('view-prescriptions');
    Route::get('/dispense-medications', [PharmacyController::class, 'dispenseMedications'])->name('dispense-medications');
    Route::get('/dispense-medications/{id}', [PharmacyController::class, 'showDispenseForm'])->name('show-dispense-form');
    Route::post('/dispense-medications/{id}', [PharmacyController::class, 'updateDispenseStatus'])->name('update-dispense-status');
    Route::get('/inventory-management', [PharmacyController::class, 'inventoryManagement'])->name('inventory-management');
    Route::post('/inventory-management', [PharmacyController::class, 'storeInventory'])->name('store-inventory');
    Route::get('/check-expiry', [PharmacyController::class, 'checkExpiry'])->name('check-expiry');
    Route::get('/generate-reports', [PharmacyController::class, 'generateReports'])->name('generate-reports');
});

require __DIR__.'/auth.php';
