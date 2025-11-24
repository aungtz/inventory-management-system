<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\StockControlController;
use App\Exports\StocksExport;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ItemController;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StocksImport;
use Illuminate\Http\Request;

// Redirect root URL to login page
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Handle login form submit

Route::post('/login', [LoginController::class, 'login']);
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Handle logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/products', [ProductManagementController::class, 'index'])
    ->name('products.index')
    ->middleware('auth');

Route::get('/productmanagements', [ProductManagementController::class, 'index'])->name('products.index');
Route::post('/productmanagements/store', [ProductManagementController::class, 'store'])->name('products.store');
Route::delete('/productmanagements/{id}', [ProductManagementController::class, 'destroy'])->name('products.destroy');

Route::get('/stock', [StockControlController::class, 'index'])->name('inventory.index');
Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/sales', [SalesController::class, 'index'])->name('sales');


Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');


Route::get('/inventory/export-excel', function () {
    return Excel::download(new StocksExport, 'stocks.xlsx');
})->name('inventory.exportExcel');

Route::post('/inventory/import-excel', function (Request $request) {
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    try {
        Excel::import(new StocksImport, $request->file('file'));

        // Success message
        return redirect()->back()->with('success', 'Stocks imported successfully!');
    } catch (\Exception $e) {
        // Error message
        return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
    }
})->name('inventory.importExcel');


Route::get('/inventory/export-pdf', [StockControlController::class, 'exportPDF'])->name('inventory.exportPDF');
Route::get('/inventory/export-csv', [StockControlController::class, 'exportCSV'])->name('inventory.exportCSV');
Route::get('/test-upload', function () {
    Storage::put('public/items/test.txt', 'hello world');
    return 'done';
});

Route::get('/check-item-code', function (Request $request) {
    $exists = \App\Models\Item::where('Item_Code', $request->code)->exists();
    return response()->json(['exists' => $exists]);
});

Route::get('/export-items', [ItemController::class, 'exportItems'])->name('export.items');
Route::get('/export-skus', [ItemController::class, 'exportSkus'])->name('export.skus');
Route::get('/export-all', [ItemController::class, 'exportAll'])->name('export.all');
