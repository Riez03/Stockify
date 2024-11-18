<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductAttributesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockTransactionsController;

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

Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('suppliers', SuppliersController::class);

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductsController::class, 'index'])->name('products.index');
            Route::post('/store', [ProductsController::class, 'store'])->name('products.store');
            Route::get('/{id}', [ProductsController::class, 'show'])->name('products.show');
            Route::put('/{id}', [ProductsController::class, 'update'])->name('products.update');
            Route::put('/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
            Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
        });
        Route::prefix('products/categories')->group(function () {
            Route::get('/all', [CategoriesController::class, 'index'])->name('categories.index');
            Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
            Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show');
            Route::put('/{id}', [CategoriesController::class, 'update'])->name('categories.update');
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
        });
    });
});

Route::group(['middleware' => 'staff'], function () {
    Route::prefix('staff')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');
    });
});

require __DIR__ . '/auth.php';
