<?php

use App\Http\Controllers\CategoyController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
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
    Route::post('/category/upload', [CategoyController::class, 'upload'])->name('category.upload');
    Route::post('/product/upload', [CategoyController::class, 'upload'])->name('product.upload');
});

require __DIR__ . '/auth.php';
