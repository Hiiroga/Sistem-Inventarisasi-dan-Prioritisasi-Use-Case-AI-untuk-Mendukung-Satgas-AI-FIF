<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UseCaseController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome')->name('home');

Route::get('/use-cases-export', [UseCaseController::class, 'export'])->name('use-cases.export');
Route::resource('use-cases', UseCaseController::class);

Route::get('/dashboard-usecase', [DashboardController::class, 'index'])->name('dashboard.usecase');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';