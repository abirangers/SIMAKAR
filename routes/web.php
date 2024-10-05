<?php

use App\Http\Controllers\Admin\CashierUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', 'login', 301);

Route::middleware('auth')->group(function () {
    Route::middleware('isAdmin')->prefix('admin')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('menu', MenuController::class);
        Route::resource('cashier', CashierUserController::class);
        Route::resource('pendapatan', PendapatanController::class);
        Route::get('/pendapatan/{id}/cetak', [PendapatanController::class, 'cetakOrder'])->name('pendapatan.cetak');
    });

    Route::middleware('isCashier')->prefix('kasir')->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('kasir.index');
        Route::post('/store', [CashierController::class, 'store'])->name('kasir.store');
    });
});

require __DIR__ . '/auth.php';
