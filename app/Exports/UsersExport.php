<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users->map(function ($user, $index) {
            return [
                'No' => $index + 1,
                'DDUC ID' => $user->dduc_id ?? 'N/A',
                'Name' => $user->name ?? 'N/A',
                'Role' => $user->role ?? 'N/A',
                'Status' => $user->is_active ? 'Active' : 'Inactive',
                'Created' => $user->created_at ? $user->created_at->format('M d, Y') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'DDUC ID',
            'Name',
            'Role',
            'Status',
            'Created',
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
        return 'Users Report';
    }
}
