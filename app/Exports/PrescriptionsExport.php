<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PrescriptionsExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $prescriptions;

    public function __construct($prescriptions)
    {
        $this->prescriptions = $prescriptions;
    }

    public function collection()
    {
        return $this->prescriptions->map(function ($prescription, $index) {
            return [
                'No' => $index + 1,
                'Patient' => $prescription->patient->full_name ?? 'N/A',
                'Doctor' => $prescription->prescribedBy->name ?? 'N/A',
                'Date' => $prescription->created_at ? $prescription->created_at->format('M d, Y') : 'N/A',
                'Status' => ucfirst($prescription->status ?? 'N/A'),
                'Items Count' => $prescription->items->count() ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Patient',
            'Doctor',
            'Date',
            'Status',
            'Items Count',
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
        return 'Prescriptions Report';
    }
}
