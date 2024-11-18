<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductAttributesController;
use App\Http\Controllers\StockTransactionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('suppliers')->group(function () {
//     Route::get('/', [SuppliersController::class, 'index'])->name('suppliers.index');
//     Route::post('/store', [SuppliersController::class, 'store'])->name('suppliers.store'); 
//     Route::get('/{id}', [SuppliersController::class, 'show'])->name('suppliers.show'); 
//     Route::put('/{id}', [SuppliersController::class, 'update'])->name('suppliers.update'); 
//     Route::delete('/{id}', [SuppliersController::class, 'destroy'])->name('suppliers.destroy');
// });

// Route::prefix('products')->group(function () {
//     Route::get('/', [ProductsController::class, 'index'])->name('products.index');
//     Route::post('/store', [ProductsController::class, 'store'])->name('products.store'); 
//     Route::get('/{id}', [ProductsController::class, 'show'])->name('products.show'); 
//     Route::put('/{id}', [ProductsController::class, 'update'])->name('products.update'); 
//     Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
// });

// Route::prefix('products/categories')->group(function () {
//     Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
//     Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store'); 
//     Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show'); 
//     Route::put('/{id}', [CategoriesController::class, 'update'])->name('categories.update'); 
//     Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
// });

// Route::resource('transaction', StockTransactionsController::class);
