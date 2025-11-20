<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemImportController extends Controller
{
    public function preview(Request $request)
{
    $request->validate([
        'items_file' => 'required|file|mimes:xlsx,xls,csv'
    ]);

    $file = $request->file('items_file');

    $rows = Excel::toArray([], $file)[0]; // get first sheet

    $validRows = [];
    $errorRows = [];

    foreach ($rows as $index => $row) {
        // Skip header row
        if ($index === 0) continue;

        $errorMsg = [];
        $itemCode = $row[0] ?? null;
        $itemName = $row[1] ?? null;
        $janCD = $row[2] ?? null;
        $quantity = $row[11] ?? null;

        if (!$itemCode) $errorMsg[] = 'Item_Code required';
        if (!$itemName) $errorMsg[] = 'Item_Name required';
        if ($janCD && strlen($janCD) > 13) $errorMsg[] = 'JanCD too long';
        if ($quantity && !is_numeric($quantity)) $errorMsg[] = 'Quantity must be numeric';

        if (count($errorMsg) > 0) {
            $row['Error_Msg'] = implode(', ', $errorMsg);
            $errorRows[] = $row;
        } else {
            $validRows[] = $row;
        }
    }

    return response()->json([
        'total' => count($rows) - 1,
        'valid' => count($validRows),
        'errors' => count($errorRows),
        'errorRows' => $errorRows
    ]);
}


public function import(Request $request)
{
    $request->validate([
        'valid_rows' => 'required|array'
    ]);

    $validRows = $request->valid_rows;

    $log = ItemImportLog::create([
        'Import_Type' => 1, // Items
        'Record_Count' => count($validRows),
        'Error_Count' => 0, // can update later if needed
        'Imported_By' => auth()->id(),
        'Imported_Date' => now(),
    ]);

    foreach ($validRows as $row) {
        ItemImportDataLog::create([
            'ImportLog_ID' => $log->ImportLog_ID,
            'Item_Code' => $row[0],
            'Item_Name' => $row[1],
            'JanCD' => $row[2],
            'MakerName' => $row[3] ?? null,
            'Memo' => $row[4] ?? null,
            'ListPrice' => $row[5] ?? null,
            'SalePrice' => $row[6] ?? null,
            'Size_Name' => $row[7] ?? null,
            'Color_Name' => $row[8] ?? null,
            'Size_Code' => $row[9] ?? null,
            'Color_Code' => $row[10] ?? null,
            'JanCode' => $row[11] ?? null,
            'Quantity' => $row[12] ?? null,
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Items imported successfully',
        'ImportLog_ID' => $log->ImportLog_ID
    ]);
}

}
