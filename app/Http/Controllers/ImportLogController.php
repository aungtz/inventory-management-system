<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemImportLog;
use App\Models\ItemImportDataLog;
use App\Models\ItemImportErrorLog;


class ImportLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $logs = ItemImportLog::orderBy('ImportLog_ID', 'DESC')->get();
    return view('import.importLog', compact('logs'));
    }

    public function importSkuPage(){
        return view('import.skuMasterImport');
    }

    public function importItemPage(){
        return view('import.itemMasterImport');
    }

    public function itemPreview(){
        return view('import.itemPreview');
    }
    public function skuPreview(){
        return view('import.skuPreview');
    }
        public function itemDetails($id)
        {
            $log = ItemImportLog::findOrFail($id);

            $items = ItemImportDataLog::where('ImportLog_ID', $id)->get();

            foreach ($items as $row) {
                $row->Status = 'Valid';
                $row->Error_Msg = null;

                $row->ListPrice = $row->ListPirce ?? null;
                $row->JanCD     = $row->JanCD ?? $row->JanCode ?? null;
            }

            return view('import.itemDetails', compact('log', 'items'));
        }                       

            public function errorDetails($id)
        {
            $log = ItemImportLog::findOrFail($id);

            $items = ItemImportErrorLog::where('ImportLog_ID', $id)->get();

            foreach ($items as $row) {
                $row->Status = 'Error';

                $row->ListPrice = $row->ListPirce ?? null;
                $row->JanCD     = $row->JanCD ?? $row->JanCode ?? null;
            }

            return view('import.itemErrorDetails', compact('log', 'items'));
        }




  // Display SKU valid rows
public function skuDetails($id)
{
    $log = ItemImportLog::findOrFail($id);

    $items = ItemImportDataLog::where('ImportLog_ID', $id)->get();

    foreach ($items as $row) {
        $row->Status = 'Valid';

        // Normalize fields
        $row->SizeName   = $row->Size_Name ?? null;
        $row->ColorName  = $row->Color_Name ?? null;
        $row->SizeCode   = $row->Size_Code ?? null;
        $row->ColorCode  = $row->Color_Code ?? null;
        $row->JanCD      = $row->JanCD ?? $row->JanCode ?? null;
        $row->Quantity   = $row->Quantity ?? 0;
    }

    return view('import.skuDetails', compact('log', 'items'));
}

// Display SKU error rows
public function skuErrorDetails($id)
{
    $log = ItemImportLog::findOrFail($id);

    $items = ItemImportErrorLog::where('ImportLog_ID', $id)->get();

    foreach ($items as $row) {
        $row->Status = 'Error';

        // Normalize fields
        $row->SizeName   = $row->Size_Name ?? null;
        $row->ColorName  = $row->Color_Name ?? null;
        $row->SizeCode   = $row->Size_Code ?? null;
        $row->ColorCode  = $row->Color_Code ?? null;
        $row->JanCD      = $row->JanCD ?? $row->JanCode ?? null;
        $row->Quantity   = $row->Quantity ?? 0;
    }

    return view('import.skuErrorDetails', compact('log', 'items'));
}


         public function processImport(Request $request)
{
    \Log::info("🔥 PROCESS IMPORT CALLED");

    try {

        \Log::info("📥 RAW REQUEST", [
            'valid' => $request->valid,
            'errors' => $request->errors,
            'import_type' => $request->import_type
        ]);

        $valid = $request->valid ?? [];
        $errors = $request->errors ?? [];
        $type = $request->import_type;
        $user = auth()->user()->name ?? 'Unknown';

        \Log::info("📊 Parsed Data Counts", [
            'valid_count' => count($valid),
            'error_count' => count($errors)
        ]);

        // Create Import Log
        $log = ItemImportLog::create([
            'Import_Type'  => $type,
            'Record_Count' => count($valid),
            'Error_Count'  => count($errors),
            'Imported_By'  => $user,
            'Imported_Date'=> now(),
        ]);

        \Log::info("📝 ImportLog Created", [
            'ImportLog_ID' => $log->ImportLog_ID
        ]);

        /** -------------------------
         * INSERT VALID ROWS
         * ------------------------- */
        foreach ($valid as $row_index => $row) {

            \Log::info("➡️ Inserting Valid Row", [
                'index' => $row_index,
                'row' => $row
            ]);

            if ($type == 1) {
                // ITEM MASTER IMPORT
                ItemImportDataLog::create([
                    'ImportLog_ID' => $log->ImportLog_ID,
                    'Item_Code'    => $row['Item_Code'] ?? '',
                    'Item_Name'    => $row['Item_Name'] ?? '',
                    'JanCD'        => $row['JanCD'] ?? '',
                    'MakerName'    => $row['MakerName'] ?? '',
                    'Memo'         => $row['Memo'] ?? '',
                    'ListPrice'    => $row['ListPrice'] ?? null,
                    'SalePrice'    => $row['SalePrice'] ?? null,
                ]);

            } else if ($type == 2) {
                // SKU IMPORT
                ItemImportDataLog::create([
                    'ImportLog_ID' => $log->ImportLog_ID,
                    'Item_Code'    => $row['Item_Code'] ?? '',

                    // Not part of SKU data
                    'Item_Name'    => null,
                    'MakerName'    => null,
                    'Memo'         => null,
                    'ListPrice'    => null,
                    'SalePrice'    => null,

                    'Size_Name'    => $row['SizeName'] ?? '',
                    'Color_Name'   => $row['ColorName'] ?? '',
                    'Size_Code'    => $row['SizeCode'] ?? '',
                    'Color_Code'   => $row['ColorCode'] ?? '',
                    'JanCD'        => $row['JanCD'] ?? '',
                    'Quantity'     => $row['Quantity'] ?? 0,
                ]);
            }
        }

        /** -------------------------
         * INSERT ERROR ROWS
         * ------------------------- */
        foreach ($errors as $row_index => $row) {

            \Log::info("❗ Inserting Error Row", [
                'index' => $row_index,
                'row' => $row
            ]);

            $errorMsg = is_array($row['errors']) 
                        ? implode("; ", $row['errors']) 
                        : ($row['errors'] ?? '');

            ItemImportErrorLog::create([
    'ImportLog_ID' => $log->ImportLog_ID,
    'Item_Code'    => $row['Item_Code'] ?? null,
    'Item_Name'    => $row['Item_Name'] ?? null,
    'JanCD'        => $row['JanCD'] ?? null,
    'MakerName'    => $row['MakerName'] ?? null,
    'Memo'         => $row['Memo'] ?? null,
    'ListPrice'    => $row['ListPrice'] ?? null,
    'SalePrice'    => $row['SalePrice'] ?? null,
    'Size_Name'    => $row['SizeName'] ?? null,
    'Color_Name'   => $row['ColorName'] ?? null,
    'Size_Code'    => $row['SizeCode'] ?? null,
    'Color_Code'   => $row['ColorCode'] ?? null,
    'Quantity'     => $row['Quantity'] ?? 0,
    'Error_Msg'    => $errorMsg,
]);

        }

        \Log::info("✅ IMPORT FINISHED SUCCESSFULLY");
        return response()->json(['success' => true]);

    } catch (\Throwable $e) {

        \Log::error("💥 IMPORT FAILED", [
            'error_message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
