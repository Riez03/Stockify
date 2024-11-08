<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Authentication
Route::get('auth/login', [AuthController::class, 'index'])->name('auth.login');
Route::get('auth/register', [AuthController::class, 'registerView'])->name('auth.register');

Route::post('auth/login', [AuthController::class, 'login'])->name('login');
Route::post('auth/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');