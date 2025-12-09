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




    public function skuDetails(){
        return view('import.skuDetails');
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

                // Insert valid rows
                foreach ($valid as $row_index => $row) {

                    \Log::info("➡️ Inserting Valid Row", [
                        'index' => $row_index,
                        'row' => $row
                    ]);

                    $row['ImportLog_ID'] = $log->ImportLog_ID;

                    ItemImportDataLog::create($row);
                }

                // Insert error rows
                // Insert error rows
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
                'Error_Msg'    => $errorMsg,   // REQUIRED (NOT NULL)
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
