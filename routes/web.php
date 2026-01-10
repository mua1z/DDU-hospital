<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('home');
});

Route::view('/about', 'about');
Route::view('/services', 'services');
Route::view('/contact', 'contact');

// Language Switch Route
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'am', 'om'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');


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

    // System Settings
    Route::get('settings', [App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('settings.update');

    // System Logs
    Route::get('logs', [App\Http\Controllers\Admin\AdminLogsController::class, 'index'])->name('logs.index');
    
    // Reports (FR-24)
    Route::get('users/export/pdf', [AdminUserController::class, 'exportPDF'])->name('users.export.pdf');
    Route::get('users/export/excel', [AdminUserController::class, 'exportExcel'])->name('users.export.excel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/notifications/mark-read', [DashboardController::class, 'markNotificationsRead'])->name('notifications.mark-read');
    Route::get('/global-search', [DashboardController::class, 'search'])->name('global.search');
});


// Reception Routes
use App\Http\Controllers\Reception\ReceptionController;
Route::middleware(['auth', 'role:receptionist'])->prefix('reception')->name('reception.')->group(function () {
    Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('dashboard');
    Route::get('/register-patient', [ReceptionController::class, 'registerPatient'])->name('register-patient');
    Route::post('/register-patient', [ReceptionController::class, 'storePatient'])->name('store-patient');
    Route::get('/search-patients', [ReceptionController::class, 'searchPatients'])->name('search-patients');
    Route::get('/view-patient/{id}', [ReceptionController::class, 'viewPatient'])->name('view-patient');
    Route::get('/schedule-appointments', [ReceptionController::class, 'scheduleAppointments'])->name('schedule-appointments');
    Route::post('/schedule-appointments', [ReceptionController::class, 'storeAppointment'])->name('store-appointment');
    Route::post('/appointments/{id}/approve', [ReceptionController::class, 'approveRequest'])->name('approve-request');
    Route::get('/manage-walkin', [ReceptionController::class, 'manageWalkin'])->name('manage-walkin');
    
    // Reports (FR-24)
    Route::get('/patients/export/pdf', [ReceptionController::class, 'exportPatientsPDF'])->name('patients.export.pdf');
    Route::get('/patients/export/excel', [ReceptionController::class, 'exportPatientsExcel'])->name('patients.export.excel');
    Route::get('/appointments/export/pdf', [ReceptionController::class, 'exportAppointmentsPDF'])->name('appointments.export.pdf');
    Route::get('/appointments/export/excel', [ReceptionController::class, 'exportAppointmentsExcel'])->name('appointments.export.excel');
});

// Doctor Routes
use App\Http\Controllers\Doctor\DoctorController;
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/view-appointments', [DoctorController::class, 'viewAppointments'])->name('view-appointments');
    
    // Appointment Actions (FR-12)
    Route::post('/appointments/{appointment}/approve', [DoctorController::class, 'approveAppointment'])->name('appointments.approve');
    Route::post('/appointments/{appointment}/reject', [DoctorController::class, 'rejectAppointment'])->name('appointments.reject');
    Route::post('/appointments/{appointment}/reschedule', [DoctorController::class, 'rescheduleAppointment'])->name('appointments.reschedule');

    Route::get('/request-lab-test', [DoctorController::class, 'requestLabTest'])->name('request-lab-test');
    Route::post('/request-lab-test', [DoctorController::class, 'storeLabRequest'])->name('store-lab-request');
    Route::get('/view-lab-results', [DoctorController::class, 'viewLabResults'])->name('view-lab-results');
    Route::get('/view-lab-results/{id}', [DoctorController::class, 'viewResultDetails'])->name('view-result-details');

    // Document History
    Route::get('/document-history', [DoctorController::class, 'documentHistory'])->name('document-history');
    Route::post('/document-history', [DoctorController::class, 'storeMedicalRecord'])->name('store-medical-record');
    Route::get('/write-prescription', [DoctorController::class, 'writePrescription'])->name('write-prescription');
    Route::post('/write-prescription', [DoctorController::class, 'storePrescription'])->name('store-prescription');
    Route::post('/appointments/{appointment}/consult', [DoctorController::class, 'consultAppointment'])->name('appointments.consult');
    
    // Reports (FR-24)
    Route::get('/appointments/export/pdf', [DoctorController::class, 'exportAppointmentsPDF'])->name('appointments.export.pdf');
    Route::get('/appointments/export/excel', [DoctorController::class, 'exportAppointmentsExcel'])->name('appointments.export.excel');
    Route::get('/prescriptions/export/excel', [DoctorController::class, 'exportPrescriptionsExcel'])->name('prescriptions.export.excel');
});

// Lab Routes
use App\Http\Controllers\Lab\LabController;
Route::middleware(['auth', 'role:lab_technician'])->prefix('lab')->name('lab.')->group(function () {
    Route::get('/dashboard', [LabController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending-requests', [LabController::class, 'pendingRequests'])->name('pending-requests');
    Route::get('/view-request/{id}', [LabController::class, 'viewRequestDetails'])->name('view-request-details');
    Route::get('/process-test', function() { return redirect()->route('lab.pending-requests'); })->name('process-test');
    Route::get('/process-test/{id}', [LabController::class, 'processTest'])->name('process-test-id');
    Route::post('/process-test/{id}', [LabController::class, 'updateRequestStatus'])->name('update-request-status');
    Route::get('/upload-results', [LabController::class, 'uploadResults'])->name('upload-results');
    Route::post('/upload-results', [LabController::class, 'storeResults'])->name('store-results');
    Route::get('/test-results', [LabController::class, 'testResults'])->name('test-results');
    Route::get('/test-results/{id}', [LabController::class, 'viewResultDetails'])->name('view-result-details');
    Route::get('/inventory', [LabController::class, 'inventory'])->name('inventory');
    Route::get('/quality-control', [LabController::class, 'qualityControl'])->name('quality-control');
    
    // Reports (FR-24)
    Route::get('/results/export/pdf', [LabController::class, 'exportResultsPDF'])->name('results.export.pdf');
    Route::get('/results/export/excel', [LabController::class, 'exportResultsExcel'])->name('results.export.excel');
});

// Pharmacy Routes
use App\Http\Controllers\Pharmacy\PharmacyController;
Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacy')->name('pharmacy.')->group(function () {
    Route::get('/dashboard', [PharmacyController::class, 'dashboard'])->name('dashboard');
    Route::get('/view-prescriptions', [PharmacyController::class, 'viewPrescriptions'])->name('view-prescriptions');
    Route::get('/view-prescription/{id}', [PharmacyController::class, 'viewPrescriptionDetails'])->name('view-prescription-details');
    Route::get('/dispense-medications', [PharmacyController::class, 'dispenseMedications'])->name('dispense-medications');
    Route::get('/dispense-medications/{id}', [PharmacyController::class, 'showDispenseForm'])->name('show-dispense-form');
    Route::post('/dispense-medications/{id}', [PharmacyController::class, 'updateDispenseStatus'])->name('update-dispense-status');
    Route::get('/inventory-management', [PharmacyController::class, 'inventoryManagement'])->name('inventory-management');
    Route::post('/inventory-management', [PharmacyController::class, 'storeInventory'])->name('store-inventory');
    Route::put('/inventory-management/{id}', [PharmacyController::class, 'updateInventory'])->name('update-inventory');
    Route::delete('/inventory-management/{id}', [PharmacyController::class, 'destroyInventory'])->name('destroy-inventory');
    Route::get('/check-expiry', [PharmacyController::class, 'checkExpiry'])->name('check-expiry');
    Route::get('/generate-reports', [PharmacyController::class, 'generateReports'])->name('generate-reports');
    
    // Reports (FR-24)
    Route::get('/inventory/export/pdf', [PharmacyController::class, 'exportInventoryPDF'])->name('inventory.export.pdf');
    Route::get('/inventory/export/excel', [PharmacyController::class, 'exportInventoryExcel'])->name('inventory.export.excel');
    Route::get('/prescriptions/export/excel', [PharmacyController::class, 'exportPrescriptionsExcel'])->name('prescriptions.export.excel');
});

// Patient Routes
use App\Http\Controllers\Patient\PatientController;
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/book-appointment', [PatientController::class, 'bookAppointment'])->name('book-appointment');
    Route::post('/book-appointment', [PatientController::class, 'storeAppointment'])->name('store-appointment');
    Route::get('/my-appointments', [PatientController::class, 'myAppointments'])->name('my-appointments');
    Route::get('/medical-records', [PatientController::class, 'medicalRecords'])->name('medical-records');
});

require __DIR__.'/auth.php';
