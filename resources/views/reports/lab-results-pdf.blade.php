<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results Report</title>
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
        
        .status-critical { color: #dc2626; font-weight: 600; }
        .status-completed { color: #059669; font-weight: 600; }
        .status-pending { color: #f59e0b; font-weight: 600; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)
            <img src="{{ $logo }}" alt="Logo" class="logo">
        @endif
        <div class="clinic-name">DDU Student Clinic</div>
        <div class="report-title">Laboratory Results Report</div>
        <div class="meta-info">
            Generated: {{ $generated_at }} | By: {{ $generated_by }}
        </div>
    </div>

    <div class="summary-box">
        <strong>Total Results:</strong> {{ $results->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Patient</th>
                <th style="width: 15%;">Test Type</th>
                <th style="width: 12%;">Test Date</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 23%;">Summary</th>
                <th style="width: 15%;">Processed By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->patient->full_name ?? 'N/A' }}</td>
                    <td>{{ $result->labRequest->test_type ?? 'N/A' }}</td>
                    <td>{{ $result->test_date ? \Carbon\Carbon::parse($result->test_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <span class="status-{{ strtolower($result->status ?? 'pending') }}">
                            {{ ucfirst($result->status ?? 'Pending') }}
                        </span>
                    </td>
                    <td>{{ \Str::limit($result->results ?? 'N/A', 50) }}</td>
                    <td>{{ $result->processedBy->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #9ca3af;">
                        No lab results found.
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
