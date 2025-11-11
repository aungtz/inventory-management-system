<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StocksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Map Excel columns to Stock model columns
        return new Stock([
            'product_name' => $row['product_name'],
            'category'     => $row['category'],
            'sku'          => $row['sku'],
            'quantity'     => $row['quantity'],
            'unit_price'   => $row['unit_price'],
            'low_stock'    => $row['low_stock'],
        ]);
    }
}
