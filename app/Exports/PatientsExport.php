<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PatientsExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $patients;

    public function __construct($patients)
    {
        $this->patients = $patients;
    }

    public function collection()
    {
        return $this->patients->map(function ($patient, $index) {
            return [
                'No' => $index + 1,
                'Card Number' => $patient->card_number ?? 'N/A',
                'Full Name' => $patient->full_name ?? 'N/A',
                'Gender' => ucfirst($patient->gender ?? 'N/A'),
                'Date of Birth' => $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : 'N/A',
                'Phone' => $patient->phone ?? 'N/A',
                'Email' => $patient->email ?? 'N/A',
                'Registered Date' => $patient->created_at ? $patient->created_at->format('M d, Y') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Card Number',
            'Full Name',
            'Gender',
            'Date of Birth',
            'Phone',
            'Email',
            'Registered Date',
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
        return 'Patients Report';
    }
}
