<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
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
            padding: 10px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
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
            font-size: 10px;
        }
        
        .summary-box strong {
            color: #1e40af;
        }
        
        .status-badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-scheduled { background: #dbeafe; color: #1e40af; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)
            <img src="{{ $logo }}" alt="Logo" class="logo">
        @endif
        <div class="clinic-name">DDU Student Clinic</div>
        <div class="report-title">Appointments Report</div>
        <div class="meta-info">
            Generated: {{ $generated_at }} | By: {{ $generated_by }}
            @if(isset($date_from) && isset($date_to))
                | Period: {{ $date_from }} - {{ $date_to }}
            @endif
        </div>
    </div>

    <div class="summary-box">
        <strong>Total Appointments:</strong> {{ $appointments->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 12%;">Apt. No.</th>
                <th style="width: 18%;">Patient</th>
                <th style="width: 15%;">Doctor</th>
                <th style="width: 11%;">Date</th>
                <th style="width: 8%;">Time</th>
                <th style="width: 10%;">Type</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Reason</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $index => $appointment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $appointment->appointment_number ?? 'N/A' }}</td>
                    <td>{{ $appointment->patient->full_name ?? 'N/A' }}</td>
                    <td>{{ $appointment->doctor->name ?? 'Not Assigned' }}</td>
                    <td>{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                    <td>{{ ucfirst($appointment->type ?? 'N/A') }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($appointment->status ?? 'scheduled') }}">
                            {{ ucfirst($appointment->status ?? 'Scheduled') }}
                        </span>
                    </td>
                    <td>{{ \Str::limit($appointment->reason ?? 'N/A', 30) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 20px; color: #9ca3af;">
                        No appointments found.
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
