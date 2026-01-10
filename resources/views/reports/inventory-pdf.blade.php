<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
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
        
        .low-stock {
            color: #dc2626;
            font-weight: 600;
        }
        
        .in-stock {
            color: #059669;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)
            <img src="{{ $logo }}" alt="Logo" class="logo">
        @endif
        <div class="clinic-name">DDU Student Clinic</div>
        <div class="report-title">Inventory Report</div>
        <div class="meta-info">
            Generated: {{ $generated_at }} | By: {{ $generated_by }}
        </div>
    </div>

    <div class="summary-box">
        <strong>Total Items:</strong> {{ $inventory->count() }} | 
        <strong class="low-stock">Low Stock Items:</strong> {{ $inventory->filter(fn($item) => $item->stock <= $item->reorder_level)->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Medication</th>
                <th style="width: 15%;">Category</th>
                <th style="width: 10%;">Stock</th>
                <th style="width: 8%;">Unit</th>
                <th style="width: 12%;">Reorder</th>
                <th style="width: 15%;">Expiry</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventory as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->medication_name ?? 'N/A' }}</td>
                    <td>{{ $item->category ?? 'N/A' }}</td>
                    <td>{{ $item->stock ?? 0 }}</td>
                    <td>{{ $item->unit ?? 'N/A' }}</td>
                    <td>{{ $item->reorder_level ?? 'N/A' }}</td>
                    <td>{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        @if($item->stock <= $item->reorder_level)
                            <span class="low-stock">Low Stock</span>
                        @else
                            <span class="in-stock">In Stock</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #9ca3af;">
                        No inventory items found.
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
