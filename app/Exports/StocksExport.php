<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StocksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Select the columns you want to export
        return Stock::select('id', 'product_name', 'category', 'sku', 'quantity', 'unit_price', 'low_stock')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Category',
            'SKU',
            'Quantity',
            'Unit Price',
            'Low Stock'
        ];
    }
}
