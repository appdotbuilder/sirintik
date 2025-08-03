<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Reports
    Route::resource('reports', ReportController::class);

    
    // Admin routes (Superadmin only)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';