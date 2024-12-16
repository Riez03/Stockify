<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductAttributesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockTransactionsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'redirectTo'])->middleware('auth')->name('index');

Route::get('/maintenance', function () {
    return view('index', [
        'title' => 'Maintenance Page',
    ]);
});

// Multi-access Route
Route::group(['middleware' => ['admin', 'manajer']], function () {
    Route::get('/transaction/preview/reportByCriteria', [StockTransactionsController::class, 'downloadReportByCriteria'])->name('criteriaReport');
    Route::get('/transaction/preview/reportTransaction', [StockTransactionsController::class, 'downloadReportByType'])->name('transactionReport');
});

Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('suppliers', SuppliersController::class);
        Route::resource('users', UserController::class);

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductsController::class, 'index'])->name('products.index');
            Route::post('/store', [ProductsController::class, 'store'])->name('products.store');
            Route::get('/{id}', [ProductsController::class, 'show'])->name('products.show');
            Route::put('/{id}', [ProductsController::class, 'update'])->name('products.update');
            Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
            Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
            Route::post('/spreadsheet/import', [ProductsController::class, 'importSpreadsheet'])->name('products.import');
            Route::post('/spreadsheet/export', [ProductsController::class, 'exportSpreadsheet'])->name('products.export');
        });
        Route::prefix('products/categories')->group(function () {
            Route::get('/all', [CategoriesController::class, 'index'])->name('categories.index');
            Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
            Route::get('/{id}/edit', [CategoriesController::class, 'show'])->name('categories.show');
            Route::put('/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
            Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
        });
        Route::prefix('products/attributes')->group(function () {
            Route::get('/all', [ProductAttributesController::class, 'index'])->name('attributes.index');
            Route::post('/store', [ProductAttributesController::class, 'store'])->name('attributes.store');
            Route::get('/{id}', [ProductAttributesController::class, 'show'])->name('attributes.show');
            Route::get('/{id}/edit', [ProductAttributesController::class, 'edit'])->name('attributes.edit');
            Route::put('/{id}', [ProductAttributesController::class, 'update'])->name('attributes.update');
            Route::delete('/{id}', [ProductAttributesController::class, 'destroy'])->name('attributes.destroy');
        });
        Route::prefix('stock')->group(function () {
            Route::get('/transaction/history', [StockTransactionsController::class, 'index'])->name('stock.index');
            Route::get('/opname', [StockTransactionsController::class, 'opnameStockView'])->name('stock.opname');
            Route::post('/opname/update', [StockTransactionsController::class, 'opnameData'])->name('stock.update');
            Route::post('update/minimum-quantity', [StockTransactionsController::class, 'updateStockMinimum'])->name('stock.update-minimum');
        });

        // Define a custom route
        Route::get('/user/activities/report', [DashboardController::class, 'downloadUserActivityReport'])->name('user.activities-report');
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
    });
});

Route::group(['middleware' => 'manajer'], function () {
    Route::prefix('manajer')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('manajer.dashboard');
        
        Route::prefix('products')->group(function() {
            Route::get('/all', [ProductsController::class, 'managerView'])->name('products.manager-view');
            Route::get('/detail/{id}', [ProductsController::class, 'show'])->name('products.show');
        });
        Route::prefix('supplier')->group(function() {
            Route::get('/all', [SuppliersController::class, 'managerView'])->name('suppliers.manager-view');
        });
        Route::prefix('stock')->group(function() {
            Route::get('/transaction', [StockTransactionsController::class, 'mainTransaction'])->name('stock.transaction');
            Route::get('/opname', [StockTransactionsController::class, 'opnameStockManagerView'])->name('stock.manager-opname');
            Route::post('/stock/opname/update', [StockTransactionsController::class, 'opnameData'])->name('stock.update');
            Route::post('/transaction/store', [StockTransactionsController::class, 'store'])->name('stock.store');
        });
    });
});

Route::group(['middleware' => 'staff'], function () {
    Route::prefix('staff')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

        Route::prefix('stock')->group(function() {
            Route::get('/observe', [StockTransactionsController::class, 'confirmationStockView'])->name('stock.observe');
            Route::post('/observe/confirmation/{id}', [StockTransactionsController::class, 'stockConfirmation'])->name('stock.update-confirmation');
        });
    });
});

require __DIR__ . '/auth.php';
