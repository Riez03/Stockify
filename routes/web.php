<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

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
        Route::resource('products', ProductsController::class);
    });

    Route::prefix('products/categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });
});

require __DIR__ . '/auth.php';
