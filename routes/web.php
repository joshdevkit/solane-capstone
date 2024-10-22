<?php

use App\Http\Controllers\CategoyController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SuppliersController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('category', CategoyController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::post('/category/upload', [CategoyController::class, 'upload'])->name('category.upload');
    Route::post('/product/upload', [CategoyController::class, 'upload'])->name('product.upload');
    Route::get('/get-serial-numbers/{productId}', [SalesController::class, 'getSerialNumbers']);
});

require __DIR__ . '/auth.php';
