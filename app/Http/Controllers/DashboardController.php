<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->latest()->get();
        return view('dashboard.index', compact('products')); // dashboard folder and blade
    }
}
