# Quick Integration Guide - Adding Report Buttons to Dashboards

This guide shows how to quickly add download buttons to existing dashboard views.

## Method 1: Using the Reusable Component (Recommended)

Add this line where you want the buttons to appear (usually near the page title):

### Admin - Users Page
```blade
{{-- File: resources/views/admin/users/index.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
    @include('components.report-buttons', [
        'pdfRoute' => route('admin.users.export.pdf'),
        'excelRoute' => route('admin.users.export.excel')
    ])
</div>
```

### Reception - Patients Page
```blade
{{-- File: resources/views/reception/search-patients.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Patient Records</h1>
    @include('components.report-buttons', [
        'pdfRoute' => route('reception.patients.export.pdf'),
        'excelRoute' => route('reception.patients.export.excel')
    ])
</div>
```

### Reception - Appointments Page
```blade
{{-- File: resources/views/reception/schedule-appointments.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Appointments</h1>
    @include('components.report-buttons', [
        'pdfRoute' => route('reception.appointments.export.pdf'),
        'excelRoute' => route('reception.appointments.export.excel')
    ])
</div>
```

### Doctor - Appointments Page
```blade
{{-- File: resources/views/doctor/view-appointments.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">My Appointments</h1>
    @include('components.report-buttons', [
        'pdfRoute' => route('doctor.appointments.export.pdf'),
        'excelRoute' => route('doctor.appointments.export.excel')
    ])
</div>
```

### Doctor - Prescriptions Page (Excel Only)
```blade
{{-- File: resources/views/doctor/write-prescription.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Prescriptions</h1>
    @include('components.report-buttons', [
        'excelRoute' => route('doctor.prescriptions.export.excel')
    ])
</div>
```

### Lab - Results Page
```blade
{{-- File: resources/views/lab/test-results.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Lab Results</h1>
    @include('components.report-buttons', [
        'pdfRoute' => route('lab.results.export.pdf'),
        'excelRoute' => route('lab.results.export.excel')
    ])
</div>
```

### Pharmacy - Inventory Page
```blade
{{-- File: resources/views/pharmacy/inventory-management.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Inventory Management</h1>
    @include('components.report-buttons', [
        'pdfRoute' => route('pharmacy.inventory.export.pdf'),
        'excelRoute' => route('pharmacy.inventory.export.excel')
    ])
</div>
```

### Pharmacy - Prescriptions Page
```blade
{{-- File: resources/views/pharmacy/view-prescriptions.blade.php --}}
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Prescriptions</h1>
    @include('components.report-buttons', [
        'excelRoute' => route('pharmacy.prescriptions.export.excel')
    ])
</div>
```

## Method 2: Inline Buttons (Alternative)

If you prefer not to use the component, add these buttons directly:

```blade
<div class="flex gap-2">
    <!-- PDF Button -->
    <a href="{{ route('your.route.pdf') }}" 
       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
        PDF Report
    </a>
    
    <!-- Excel Button -->
    <a href="{{ route('your.route.excel') }}" 
       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Excel Report
    </a>
</div>
```

## Method 3: Dropdown Menu

For a more compact design, use a dropdown:

```blade
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" 
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export Report
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    
    <div x-show="open" 
         @click.away="open = false"
         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10">
        <a href="{{ route('your.route.pdf') }}" 
           class="block px-4 py-2 text-gray-800 hover:bg-red-50 hover:text-red-600 rounded-t-lg">
            📄 Download PDF
        </a>
        <a href="{{ route('your.route.excel') }}" 
           class="block px-4 py-2 text-gray-800 hover:bg-green-50 hover:text-green-600 rounded-b-lg">
            📊 Download Excel
        </a>
    </div>
</div>
```

## Available Routes Reference

### Admin
- `route('admin.users.export.pdf')`
- `route('admin.users.export.excel')`

### Reception
- `route('reception.patients.export.pdf')`
- `route('reception.patients.export.excel')`
- `route('reception.appointments.export.pdf')`
- `route('reception.appointments.export.excel')`

### Doctor
- `route('doctor.appointments.export.pdf')`
- `route('doctor.appointments.export.excel')`
- `route('doctor.prescriptions.export.excel')`

### Lab
- `route('lab.results.export.pdf')`
- `route('lab.results.export.excel')`

### Pharmacy
- `route('pharmacy.inventory.export.pdf')`
- `route('pharmacy.inventory.export.excel')`
- `route('pharmacy.prescriptions.export.excel')`

## Best Practices

1. **Position**: Place buttons in the header section near the page title
2. **Visibility**: Make buttons prominent but not overwhelming
3. **Consistency**: Use the same button style across all pages
4. **Loading State**: Consider adding loading indicators for large reports
5. **Permissions**: Buttons automatically respect user roles and permissions

## Testing

After adding buttons, test by:
1. Logging in as the appropriate user role
2. Navigating to the page
3. Clicking the PDF/Excel button
4. Verifying the download starts immediately
5. Opening the file to check formatting

---

**Integration Tip**: Start with one page (e.g., Admin Users), test thoroughly, then replicate to other pages.
