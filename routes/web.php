<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\DeliveryReceiptController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UserController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('users', UserController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('uploaded-forms', FormsController::class);
    Route::resource('returns', ReturnsController::class);

    Route::patch('/notifications/{id}/read', [StockController::class, 'markAsRead']);

    Route::post('/category/upload', [CategoryController::class, 'upload'])->name('category.upload');
    Route::post('/product/upload', [CategoryController::class, 'upload'])->name('product.upload');
    Route::get('/get-serial-numbers/{productId}', [SalesController::class, 'getSerialNumbers']);

    Route::get('pull-out', [SalesController::class, 'pullout'])->name('pullout');
    Route::post('update-tare-weight/{id}', [SalesController::class, 'updateTareWeight'])->name('update-tareweight');
    Route::get('/pullout-form', [FormsController::class, 'pullout_form'])->name('pullout-form.create');
    Route::post('/pullout-form', [FormsController::class, 'storePulloutForm'])->name('pullout-form.store');
    Route::get('/pullout-form/{id}/pdf', [FormsController::class, 'pulloutForm'])->name('pullout-form.pdf');
    Route::get('/forms', [FormsController::class, 'index'])->name('admin.forms.index');
    // Route to store the form data
    Route::post('/pullout-form/store', [FormsController::class, 'storePulloutForm'])->name('pullout-form.store');
    Route::get('/forms/delivery', [FormsController::class, 'delivery_form'])->name('delivery-form.create');
    Route::post('/forms/delivery', [FormsController::class, 'storeDeliveryForm'])->name('delivery-form.store');
    Route::get('delivery-receipt/create', [DeliveryReceiptController::class, 'create'])->name('delivery-receipt.create');
    Route::post('delivery-receipt/store', [DeliveryReceiptController::class, 'store'])->name('delivery-receipt.store');

    Route::get('create-pullout', [FormsController::class, 'pullout_form'])->name('pullout-forms');
    Route::get('create-delivery', [FormsController::class, 'delivery_form'])->name('delivery-forms');
    Route::get('create-delivery-receipt', [FormsController::class, 'delivery_receipt'])->name('delivery-receipt');

    Route::get('sales/{id}/return', [SalesController::class, 'return_items'])->name('sales-returns');

    Route::post('product-data', [ProductsController::class, 'fetch_data'])->name('product-data');
});


Route::get('/auth', [AuthenticatedSessionController::class, 'login_me'])->name('auto-login');



require __DIR__ . '/auth.php';
