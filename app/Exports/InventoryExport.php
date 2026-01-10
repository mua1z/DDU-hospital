<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $inventory;

    public function __construct($inventory)
    {
        $this->inventory = $inventory;
    }

    public function collection()
    {
        return $this->inventory->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Medication' => $item->medication_name ?? 'N/A',
                'Category' => $item->category ?? 'N/A',
                'Stock' => $item->stock ?? 0,
                'Unit' => $item->unit ?? 'N/A',
                'Reorder Level' => $item->reorder_level ?? 'N/A',
                'Expiry Date' => $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('M d, Y') : 'N/A',
                'Status' => $item->stock <= $item->reorder_level ? 'Low Stock' : 'In Stock',
                'Last Updated' => $item->updated_at ? $item->updated_at->format('M d, Y') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Medication',
            'Category',
            'Stock',
            'Unit',
            'Reorder Level',
            'Expiry Date',
            'Status',
            'Last Updated',
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
        return 'Inventory Report';
    }
}
