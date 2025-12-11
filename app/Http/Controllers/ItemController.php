<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sku;
use App\Models\ItemImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemsAndSkusExport;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    // 🧾 List all items
public function index()
{
    // $items = \App\Models\Item::with('images')->orderBy('CreatedDate', 'desc')->get();
        // $items = \App\Models\Item::with(['images', 'skus'])->orderBy('CreatedDate', 'desc')->get();
         $items = Item::with(['images', 'skus'])->orderBy('CreatedDate', 'desc')->get();

    $pivotSkus = DB::table('M_sku')
        ->select('Item_Code', 'Color_Name',
            DB::raw('SUM(CASE WHEN Size_Name = \'S\' THEN Quantity ELSE 0 END) AS S'),
            DB::raw('SUM(CASE WHEN Size_Name = \'M\' THEN Quantity ELSE 0 END) AS M'),
            DB::raw('SUM(CASE WHEN Size_Name = \'L\' THEN Quantity ELSE 0 END) AS L'),
            DB::raw('SUM(CASE WHEN Size_Name = \'XL\' THEN Quantity ELSE 0 END) AS XL')
        )
        ->groupBy('Item_Code', 'Color_Name')
        ->orderBy('Item_Code')
        ->orderBy('Color_Name')
        ->get();

    // Convert to array for easier access in Blade
    $pivotSkus = json_decode(json_encode($pivotSkus), true);

    return view('items.index', compact('items', 'pivotSkus'));
}

public function exportItems()
{
    return Excel::download(new ItemsExport, 'items.xlsx');
}

public function exportSkus()
{
    return Excel::download(new SkusExport, 'skus.xlsx');
}
public function exportAll()
{
    return Excel::download(new ItemsAndSkusExport, 'items_and_skus.xlsx');
}

    // 📝 Show the item registration form
    public function create()
    {
        return view('inventory.items'); // ✅ points to your form blade
    }

    // 💾 Save item, SKUs, and images
 public function store(Request $request)
{
    \Log::info('📦 Incoming Request Data:', $request->all());

    $request->validate([
        'Item_Code' => 'required|string|max:50',
        'Item_Name' => 'required|string|max:255',
        'JanCD'     => 'required|string|max:13',
        'MakerName' => 'required|string|max:255',
        'ListPrice'  => 'required|numeric|min:0',
        'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Check for duplicate Item_Code
    if (Item::where('Item_Code', $request->Item_Code)->exists()) {
        return redirect()->back()->withErrors(['Item_Code' => 'This Item Code already exists!']);
    }

    // CREATE MAIN ITEM
    $item = Item::create([
        'Item_Code'  => $request->Item_Code,
        'Item_Name'  => $request->Item_Name,
        'JanCD'      => $request->JanCD,
        'MakerName'  => $request->MakerName,
        'Memo'       => $request->Memo,
        'ListPrice'  => $request->ListPrice,
        'SalePrice'  => $request->SalePrice ?? $request->ListPrice,
        'CreatedBy'  => auth()->user()->name ?? 'system',
        'UpdatedBy'  => auth()->user()->name ?? 'system',
    ]);

    // CREATE SKUs FROM JSON
   if ($request->filled('skus_json')) {

    // Decode only ONCE
    $skusData = json_decode($request->skus_json, true);

    if (is_array($skusData)) {
        foreach ($skusData as $skuData) {

            // Ensure value exists and pad to 4 digits
            $colorCode = isset($skuData['colorCode']) ? str_pad((string)$skuData['colorCode'], 4, '0', STR_PAD_LEFT) : null;
            $sizeCode  = isset($skuData['sizeCode']) ? str_pad((string)$skuData['sizeCode'], 4, '0', STR_PAD_LEFT) : null;

            $item->skus()->create([
                'Size_Name'   => $skuData['sizeName'] ?? null,
                'Color_Name'  => $skuData['colorName'] ?? null,
                'Size_Code'   => $sizeCode,
                'Color_Code'  => $colorCode,
                'JanCode'     => $skuData['janCode'] ?? null,
                'Quantity'    => $skuData['stockQuantity'] ?? 0,
                'CreatedBy'   => auth()->user()->name ?? 'system',
                'UpdatedBy'   => auth()->user()->name ?? 'system',
            ]);
        }
    }
}


// ... inside your store(Request $request) ...
if ($request->hasFile('images')) {
    $disk = Storage::disk('public');

    foreach ($request->file('images') as $index => $image) {
        if (! $image || ! $image->isValid()) continue;

        // file extension
        $ext = strtolower($image->getClientOriginalExtension());
        $dotExt = '.' . $ext;

        // sanitize Item_Code as base filename
        $rawBase = $item->Item_Code ?? 'item';
        $base = preg_replace('/[^A-Za-z0-9\-_]+/', '-', $rawBase);
        $base = trim($base, '-_');
        if ($base === '') $base = 'item';

        // next serial (001, 002...)
        $maxSerial = ItemImage::where('Item_Code', $item->Item_Code)->max('Image_Serial');
        $nextSerial = ($maxSerial ? intval($maxSerial) : 0) + 1;
        $serialPadded = str_pad($nextSerial, 3, '0', STR_PAD_LEFT);

        // final intended filename (WITH extension)
        $candidate = $base . '-' . $serialPadded . $dotExt;

        // ensure uniqueness (VERY rare)
        $path = 'items/' . $candidate;
        $counter = 1;
        while ($disk->exists($path)) {
            $candidate = $base . '-' . $serialPadded . '-' . $counter . $dotExt;
            $path = 'items/' . $candidate;
            $counter++;
        }

        // store file
        $image->storeAs('items', $candidate, 'public');

        // save DB record
        ItemImage::create([
            'Item_Code'    => $item->Item_Code,
            'Image_Name'   => $candidate,
            'Image_Serial' => $nextSerial, // correct serial
            'CreatedDate'  => now(),
            'UpdatedDate'  => now(),
        ]);
    }
}




    return redirect()->route('items.index')->with('success', 'Item saved successfully!');
}

public function edit($id)
{
    $item = Item::with(['skus', 'images'])->findOrFail($id);
        return view('inventory.itemsEdit', compact('item'));

}


public function update(Request $request, $id)
{
    \Log::info('📦 Update Request Data: ' . json_encode($request->all()));
    
    // Debug uploaded files
    $uploadedFiles = $request->file('images', []);
    \Log::info('📁 Uploaded files count: ' . count($uploadedFiles));
    
    foreach ($uploadedFiles as $key => $file) {
        if ($file) {
            \Log::info("  File [{$key}]: {$file->getClientOriginalName()}, Size: {$file->getSize()} bytes, Valid: " . ($file->isValid() ? 'yes' : 'no'));
        }
    }

    try {
        $item = Item::findOrFail($id);
        
        // Log current images in database BEFORE update
        \Log::info('📊 Current images in database BEFORE update:');
        $currentImages = ItemImage::where('Item_Code', $item->Item_Code)->get();
        foreach ($currentImages as $img) {
            \Log::info("  Slot {$img->slot}: {$img->Image_Name} -> {$img->path}");
        }

        // Validate request - USING CORRECT VALIDATOR
        $validator = \Validator::make($request->all(), [  // Added backslash
            'Item_Code' => 'required|string|max:255|unique:M_Item,Item_Code,' . $id . ',Item_Code',
            'Item_Name' => 'required|string|max:255',
            'JanCD' => 'required|string|max:13',
            'MakerName' => 'required|string|max:255',
            'ListPrice' => 'required|numeric',
            'Memo' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            \Log::error('❌ Validation failed:', $validator->errors()->toArray());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Update item
        $item->update($validated);

        $imageStates = $request->input('imageStates', []);
        $imageNames  = $request->input('imageNames', []);
        
        \Log::info('🎯 Image States: ' . json_encode($imageStates));
        \Log::info('🏷️  Image Names: ' . json_encode($imageNames));

        foreach ($imageStates as $slot => $state) {
            $slot = (int)$slot;
            $imageName = $imageNames[$slot] ?? null;
            $file = $uploadedFiles[$slot] ?? null;

            \Log::info("🔄 Processing slot {$slot}: state={$state}, imageName={$imageName}, hasFile=" . ($file ? 'yes' : 'no'));

            // Get existing image for this slot
            $existingImage = ItemImage::where('Item_Code', $item->Item_Code)
                                      ->where('slot', $slot)
                                      ->first();

            \Log::info("  Existing image in DB: " . ($existingImage ? "Yes (ID: {$existingImage->id})" : "No"));

            if ($state === 'delete') {
                if ($existingImage) {
                    \Log::info("  Deleting image: {$existingImage->path}");
                    if (!empty($existingImage->path) && \Storage::disk('public')->exists($existingImage->path)) {
                        \Storage::disk('public')->delete($existingImage->path);
                        \Log::info("  File deleted from storage");
                    }
                    $existingImage->delete();
                    \Log::info("✅ Deleted image in slot {$slot}");
                } else {
                    \Log::info("  No image to delete in slot {$slot}");
                }
            } 
            elseif ($state === 'new') {
                if ($file && $file->isValid()) {
                    \Log::info("  Processing new file: {$file->getClientOriginalName()}");
                    
                    // Delete old image if exists
                    if ($existingImage && !empty($existingImage->path)) {
                        \Log::info("  Deleting old image: {$existingImage->path}");
                        if (\Storage::disk('public')->exists($existingImage->path)) {
                            \Storage::disk('public')->delete($existingImage->path);
                            \Log::info("  Old file deleted from storage");
                        }
                    }
                    // OLD CODE:
                    // Save new file
                    $userFileName = $imageName ?: $file->getClientOriginalName();
                    $uniqueStoredName = time() . '_' . uniqid() . '_' . $userFileName;
                    $path = $file->storeAs('items', $uniqueStoredName, 'public');

                    // NEW CODE:
                    // Save new file with original name
                    $userFileName = $imageName ?: $file->getClientOriginalName();
                    $path = $file->storeAs('items', $userFileName, 'public');
                    

 
                    
                    \Log::info("  Saved new file to: {$path}");
                    \Log::info("  File exists in storage: " . (\Storage::disk('public')->exists($path) ? 'Yes' : 'No'));
                    
                    // Create or update
                    if ($existingImage) {
                        $existingImage->update([
                            'Image_Name' => $userFileName,
                            'path' => $path
                        ]);
                        \Log::info("✅ Updated existing record in slot {$slot}");
                    } else {
                        ItemImage::create([
                            'Item_Code' => $item->Item_Code,
                            'slot' => $slot,
                            'Image_Name' => $userFileName,
                            'path' => $path
                        ]);
                        \Log::info("✅ Created new record in slot {$slot}");
                    }
                } else {
                    \Log::warning("⚠️ State is 'new' but no valid file for slot {$slot}");
                    if ($file) {
                        \Log::warning("  File error: " . ($file->getErrorMessage() ?: 'Unknown error'));
                    }
                    
                    // If state is 'new' but no file, this is an error
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Image slot {$slot} marked as 'new' but no valid file provided"
                        ], 400);
                    }
                }
            } 
            elseif ($state === 'existing') {
                if ($existingImage) {
                    \Log::info("  Keeping existing image: {$existingImage->path}");
                    if ($imageName && $existingImage->Image_Name !== $imageName) {
                        $existingImage->update(['Image_Name' => $imageName]);
                        \Log::info("✅ Updated image name in slot {$slot}: {$imageName}");
                    }
                }
            }
        }

        // Log current images in database AFTER update
        \Log::info('📊 Current images in database AFTER update:');
        $updatedImages = ItemImage::where('Item_Code', $item->Item_Code)->get();
        foreach ($updatedImages as $img) {
            $exists = !empty($img->path) && \Storage::disk('public')->exists($img->path) ? '✅' : '❌';
            \Log::info("  {$exists} Slot {$img->slot}: {$img->Image_Name} -> {$img->path}");
        }

        // Handle SKUs
        $skus = json_decode($request->input('skus_json', '[]'), true);
        if ($skus) {
            $item->skus()->delete();
            foreach ($skus as $sku) {
                
                $item->skus()->create([
                    'Size_Name'  => $sku['sizeName'] ?? null,
                    'Color_Name' => $sku['colorName'] ?? null,

                     // 👇 PAD HERE
    'Size_Code'  => isset($sku['sizeCode']) ? $this->pad4($sku['sizeCode']) : null,
    'Color_Code' => isset($sku['colorCode']) ? $this->pad4($sku['colorCode']) : null,
                    'JanCode'    => $sku['janCode'] ?? null,
                    'Quantity'   => $sku['stockQuantity'] ?? 0
                ]);
            }
        }

        // Return JSON response if it's an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'redirect' => route('items.index')
            ]);
        }

        return redirect()->route('items.index')->with('success', 'Item updated successfully');

    } catch (\Exception $e) {
        \Log::error('❌ Update error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}
private function pad4($value)
{
    return str_pad((string)$value, 4, '0', STR_PAD_LEFT);
}


}
