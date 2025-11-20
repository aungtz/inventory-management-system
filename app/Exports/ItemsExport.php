<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemsExport implements FromCollection, WithHeadings, WithColumnFormatting, WithStyles
{
    public function collection()
    {
        return Item::select(
            'Item_Code', 'Item_Name', 'JanCD', 'MakerName', 'Memo',
            'BasicPrice', 'ListPrice', 'CostPrice', 'SalePrice',
            'CreatedBy', 'UpdatedBy'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Item Code', 'Item Name', 'JanCD', 'Maker Name', 'Memo',
            'Basic Price', 'List Price', 'Cost Price', 'Sale Price',
            'Created By', 'Updated By'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // BasicPrice
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // ListPrice
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // CostPrice
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // SalePrice
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A:K')->getAlignment()->setVertical('center'); // all rows vertical center
        $sheet->getStyle('F:I')->getAlignment()->setHorizontal('right'); // numeric/currency right
        $sheet->getStyle('A:E')->getAlignment()->setHorizontal('left');   // text left
    }
}
