<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoyController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportsController;
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

    Route::resource('category', CategoyController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('sales', SalesController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('users', UserController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('uploaded-forms', FormsController::class);
    Route::resource('returns', ReturnsController::class);

    Route::patch('/notifications/{id}/read', [StockController::class, 'markAsRead']);

    Route::post('/category/upload', [CategoyController::class, 'upload'])->name('category.upload');
    Route::post('/product/upload', [CategoyController::class, 'upload'])->name('product.upload');
    Route::get('/get-serial-numbers/{productId}', [SalesController::class, 'getSerialNumbers']);

    Route::get('pull-out', [SalesController::class, 'pullout'])->name('pullout');
    Route::post('update-tare-weight/{id}', [SalesController::class, 'updateTareWeight'])->name('update-tareweight');


    Route::get('create-pullout', [FormsController::class, 'pullout_form'])->name('pullout-forms');
    Route::get('create-delivery', [FormsController::class, 'delivery_form'])->name('delivery-forms');
    Route::get('create-delivery-receipt', [FormsController::class, 'delivery_receipt'])->name('delivery-receipt');

    Route::get('sales/{id}/return', [SalesController::class, 'return_items'])->name('sales-returns');
    Route::get('product-data/{category}', [ProductsController::class, 'getProducts'])->name('get-product-data');
    Route::get('check-serial-existence', [ProductsController::class, 'checkSerialExistence'])->name('check-serial-existence');
    Route::post('product-data', [ProductsController::class, 'fetch_data'])->name('product-data');
    Route::get('product-code', [ProductsController::class, 'check_code'])->name('check-code');

    Route::get('get-pullout-products', [FormsController::class, 'getPulloutProducts'])->name('get-pullout-products');
    Route::get('get-delivery-products', [FormsController::class, 'getProductsForDelivery'])->name('get-delivery-products');
    Route::post('send-low-stock-notifications', [AdminDashboardController::class, 'sendLowStockNotifications'])->name('notification');


    //reports inventory - products
    Route::get('inventory-reports', [ReportsController::class, 'inventory'])->name('inventory.reports.generate');
    Route::get('generate-inventory-reports', [ReportsController::class, 'generate_inventory'])->name('generate.inventory.reports');

    // returns reports
    Route::get('returns-reports', [ReportsController::class, 'returns'])->name('returns.reports.generate');
    Route::get('generate-returns-reports', [ReportsController::class, 'generate_returns'])->name('generate.reports.returns');

    //purchase rerpots

    Route::get('purchase-reports', [ReportsController::class, 'purchase'])->name('generate-purchase-reports');
    Route::get('generate-purchase-reports', [ReportsController::class, 'generate_purchase'])->name('purchase-reports');

    //sales reports button

    Route::get('sales-reports', [ReportsController::class, 'sales'])->name('sales.reports.generate');
    Route::get('generate-sales-reports', [ReportsController::class, 'generate_sales'])->name('generate.reports.sales');


    //forecasting
    Route::get('forecasting', [ForecastController::class, 'forecast'])->name('forecast');
    Route::post('generate-forecast', [ForecastController::class, 'generateForecast'])->name('forecast.generate');

    //forms route
    Route::prefix('forms')->group(function () {
        Route::get('delivery/{id}/pdf', [FormsController::class, 'deliveryForm'])->name('delivery-form.pdf');
        Route::post('delivery', [FormsController::class, 'storeDeliveryForm'])->name('delivery-form.store');
        Route::post('pullout', [FormsController::class, 'storePulloutForm'])->name('pullout-form.store');
        Route::get('pullout/{id}/pdf', [FormsController::class, 'pulloutForm'])->name('pullout-form.pdf');
        Route::get('create-delivery-receipt', [FormsController::class, 'delivery_receipt'])->name('delivery-receipt');
        Route::post('create-delivery-receipt', [FormsController::class, 'storeDeliveryReceipt'])->name('delivery-receipt.store');
    });
});


Route::get('/auth', [AuthenticatedSessionController::class, 'login_me'])->name('auto-login');



require __DIR__ . '/auth.php';
