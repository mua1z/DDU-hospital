<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LabResultsExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results->map(function ($result, $index) {
            return [
                'No' => $index + 1,
                'Patient' => $result->patient->full_name ?? 'N/A',
                'Test Type' => $result->labRequest->test_type ?? 'N/A',
                'Test Date' => $result->test_date ? \Carbon\Carbon::parse($result->test_date)->format('M d, Y') : 'N/A',
                'Status' => ucfirst($result->status ?? 'N/A'),
                'Summary' => $result->results ?? 'N/A',
                'Processed By' => $result->processedBy->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Patient',
            'Test Type',
            'Test Date',
            'Status',
            'Summary',
            'Processed By',
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
        return 'Lab Results Report';
    }
}
