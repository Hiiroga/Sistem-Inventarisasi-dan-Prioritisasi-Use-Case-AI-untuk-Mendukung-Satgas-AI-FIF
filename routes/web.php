<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortalLoginController;
use App\Http\Controllers\UseCaseController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('portal.login');
})->name('home');

// Halaman login gabungan (1 halaman, ada toggle Admin/User)
Route::get('/masuk', [PortalLoginController::class, 'show'])->name('portal.login');
Route::post('/masuk', [PortalLoginController::class, 'login'])->name('portal.login.submit');
Route::post('/keluar', [PortalLoginController::class, 'logout'])->name('portal.logout');

// Halaman Bantuan / FAQ (dapat diakses semua user yang login)
Route::middleware(['auth'])->get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');

// Rute untuk User biasa (login wajib, guard web/default)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/usulkan', [UserDashboardController::class, 'create'])->name('create');
    Route::post('/usulkan', [UserDashboardController::class, 'store'])->name('store');
    Route::get('/usulkan/{useCase}/edit', [UserDashboardController::class, 'edit'])->name('edit');
    Route::put('/usulkan/{useCase}', [UserDashboardController::class, 'update'])->name('update');
});

// Route kompatibilitas untuk halaman pengaturan akun bawaan Laravel/Livewire.
// Layout settings masih menggunakan nama route "dashboard".
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

// Rute Admin (guard web yang sama, dibatasi berdasarkan role)
Route::middleware(['admin'])->group(function () {
    Route::get('/use-cases-export', [UseCaseController::class, 'export'])->name('use-cases.export');
    Route::post('/use-cases/{useCase}/analisis-otomatis', [UseCaseController::class, 'analisisOtomatis'])->name('use-cases.analisis-otomatis');
    Route::resource('use-cases', UseCaseController::class);
    Route::get('/dashboard-usecase', [DashboardController::class, 'index'])->name('dashboard.usecase');

    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/promote/{user}', [AdminUserController::class, 'promote'])->name('promote');
        Route::delete('/demote/{admin}', [AdminUserController::class, 'demote'])->name('demote');
        Route::delete('/user/{user}', [AdminUserController::class, 'destroyUser'])->name('destroy-user');
    });
});

require __DIR__.'/settings.php';
