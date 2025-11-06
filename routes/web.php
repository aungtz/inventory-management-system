<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManagementController;

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
