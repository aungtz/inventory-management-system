<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ItemsAndSkusExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new \App\Exports\ItemsExport(), // Items sheet
            new \App\Exports\SkusExport(),  // SKUs sheet
        ];
    }
}
