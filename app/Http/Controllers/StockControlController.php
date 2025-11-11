<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Correct import
use Illuminate\Support\Facades\Response;

class StockControlController extends Controller
{
    public function index()
    {
        // Dummy data to test Blade
        $stocks = Stock::latest()->get();
        return view('inventory.stockControl', compact('stocks'));
    }

    public function exportPDF()
    {
        $stocks = Stock::all();

        $pdf = Pdf::loadView('inventory.stocks-pdf', compact('stocks')); // <-- Use Pdf Facade

        // Download the PDF
        return $pdf->download('stocks.pdf');
    }
    public function exportCSV()
    {
        $stocks = Stock::all();

        $filename = "stocks.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($stocks) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['Product Name', 'Category', 'SKU', 'Quantity', 'Unit Price', 'Low Stock']);

            // Data rows
            foreach ($stocks as $stock) {
                fputcsv($file, [
                    $stock->product_name,
                    $stock->category,
                    $stock->sku,
                    $stock->quantity,
                    $stock->unit_price,
                    $stock->low_stock
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
