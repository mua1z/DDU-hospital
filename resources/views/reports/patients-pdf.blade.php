<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }
        
        .logo {
            max-width: 80px;
            margin-bottom: 10px;
        }
        
        .clinic-name {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #374151;
            margin: 10px 0;
        }
        
        .meta-info {
            font-size: 10px;
            color: #6b7280;
            margin-top: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
        }
        
        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
        
        .summary-box {
            background: #f0f9ff;
            border-left: 4px solid #2563eb;
            padding: 12px;
            margin-bottom: 20px;
        }
        
        .summary-box strong {
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)
            <img src="{{ $logo }}" alt="Logo" class="logo">
        @endif
        <div class="clinic-name">DDU Student Clinic</div>
        <div class="report-title">Patients Report</div>
        <div class="meta-info">
            Generated: {{ $generated_at }} | By: {{ $generated_by }}
        </div>
    </div>

    <div class="summary-box">
        <strong>Total Patients:</strong> {{ $patients->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 12%;">Card No.</th>
                <th style="width: 25%;">Full Name</th>
                <th style="width: 8%;">Gender</th>
                <th style="width: 12%;">DOB</th>
                <th style="width: 15%;">Phone</th>
                <th style="width: 12%;">Registered</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $index => $patient)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $patient->card_number ?? 'N/A' }}</td>
                    <td>{{ $patient->full_name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($patient->gender ?? 'N/A') }}</td>
                    <td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $patient->phone ?? 'N/A' }}</td>
                    <td>{{ $patient->created_at ? $patient->created_at->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #9ca3af;">
                        No patients found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This is a system-generated report from DDU Student Clinic Management System</p>
        <p>© {{ date('Y') }} Dire Dawa University - All Rights Reserved</p>
    </div>
</body>
</html>
