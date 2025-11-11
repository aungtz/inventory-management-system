<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index()
    {
        // Total users
        $totalUsers = User::count();
        $products = Product::with('user')->latest()->get();

        // Inventory stats
        $totalProducts = Product::count();
        $inStockProducts = Product::where('stock', '>', 0)->count();
        $inventoryPercent = $totalProducts > 0 ? round(($inStockProducts / $totalProducts) * 100) : 0;

        // Optional: Low stock products
        // $lowStockCount = Product::whereColumn('stock', '<=', 'low_stock')->count();

        return view('dashboard.index', compact(
            'totalUsers',
            'totalProducts',
            'inStockProducts',
            'inventoryPercent',
            'products'
        ));
    }
}
