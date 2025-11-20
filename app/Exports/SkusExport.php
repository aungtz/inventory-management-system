<?php

namespace App\Exports;

use App\Models\Sku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkusExport implements FromCollection, WithHeadings, WithColumnFormatting, WithStyles
{
    public function collection()
    {
        return Sku::select(
            'Item_Code', 'Size_Name', 'Color_Name', 'Size_Code', 'Color_Code', 'JanCode', 'Quantity', 'CreatedBy', 'UpdatedBy'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Item Code', 'Size Name', 'Color Name', 'Size Code', 'Color Code', 'Jan Code', 'Quantity', 'Created By', 'Updated By'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER, // Quantity as integer
        ];
    }

    public function styles(Worksheet $sheet)
{
    // Vertical alignment for all cells
    $sheet->getStyle('A:I')->getAlignment()->setVertical('center');

    // Right-align numeric column (Quantity)
    $sheet->getStyle('G')->getAlignment()->setHorizontal('right');

    // Left-align text columns (A-F and H-I) — call separately
    $sheet->getStyle('A:F')->getAlignment()->setHorizontal('left');
    $sheet->getStyle('H:I')->getAlignment()->setHorizontal('left');
}

}
