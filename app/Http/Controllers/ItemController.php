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
        'BasicPrice' => 'required|numeric|min:0',
        'ListPrice'  => 'required|numeric|min:0',
        'CostPrice'  => 'required|numeric|min:0',
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
        'BasicPrice' => $request->BasicPrice,
        'ListPrice'  => $request->ListPrice,
        'CostPrice'  => $request->CostPrice,
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


  if ($request->hasFile('images')) {
    foreach ($request->file('images') as $index => $image) {
        if ($image && $image->isValid() && $image->getSize() > 0) {

            // 1. Get name input
            $rawName = $request->input('image_names')[$index] ?? $image->getClientOriginalName();

            // Trim whitespace
            $rawName = trim($rawName);

            // 2. Extract extension from uploaded file
            $ext = strtolower($image->getClientOriginalExtension());

            // 3. Check if the user already included an extension in name
            if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $rawName)) {
                // user already included extension → keep it
                $baseName = pathinfo($rawName, PATHINFO_FILENAME);
            } else {
                // user did NOT include extension → append correct extension
                $baseName = $rawName . '.' . $ext;
            }

            // 4. Build final filename (unique)
            $filename = time() . '_' . preg_replace('/\s+/', '_', $baseName);

            // 5. Store file
            $image->storeAs('items', $filename, 'public');

            // 6. Save to DB
            ItemImage::create([
                'Item_Code'   => $item->Item_Code,
                'Image_Name'  => $filename,
                'CreatedDate' => now(),
                'UpdatedDate' => now(),
            ]);
        }
    }
}


    return redirect()->route('items.index')->with('success', 'Item saved successfully!');
}

 public function edit($id)
    {
        $item = Item::with('skus', 'images')->findOrFail($id);
    return view('inventory.itemEdit', compact('item'));
    }

    // Update existing item
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'Item_Code' => 'required|string|max:255',
            'Item_Name' => 'required|string|max:255',
            'JanCD' => 'required|string|max:13',
            'MakerName' => 'required|string|max:255',
            'BasicPrice' => 'required|numeric',
            'ListPrice' => 'required|numeric',
            'CostPrice' => 'required|numeric',
            'Memo' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $item->update($validated);

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $item->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }

  public function destroy($Item_Code)
{
    // 1) Get item
    $item = Item::where('Item_Code', $Item_Code)->firstOrFail();

    // 2) Delete SKUs
    $item->skus()->delete();

    // 3) Delete Images
    $item->images()->delete();

    // 4) Delete Item
    $item->delete();

    return back()->with('success', 'Item deleted successfully!');
}



}
