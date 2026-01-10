<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AppointmentsExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $appointments;

    public function __construct($appointments)
    {
        $this->appointments = $appointments;
    }

    public function collection()
    {
        return $this->appointments->map(function ($appointment, $index) {
            return [
                'No' => $index + 1,
                'Appointment #' => $appointment->appointment_number ?? 'N/A',
                'Patient' => $appointment->patient->full_name ?? 'N/A',
                'Doctor' => $appointment->doctor->name ?? 'Not Assigned',
                'Date' => $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') : 'N/A',
                'Time' => $appointment->appointment_time ?? 'N/A',
                'Type' => ucfirst($appointment->type ?? 'N/A'),
                'Status' => ucfirst($appointment->status ?? 'N/A'),
                'Reason' => $appointment->reason ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Appointment #',
            'Patient',
            'Doctor',
            'Date',
            'Time',
            'Type',
            'Status',
            'Reason',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Appointments Report';
    }
}
