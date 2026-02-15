<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductionSystemController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\ProductionControlController;
use App\Http\Controllers\BusinessModelController;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureAdminForWrite;

// Root redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // WBS Routes (Read-only for all authenticated users)
    Route::get('/wbs', [App\Http\Controllers\WBSController::class, 'index'])->name('wbs.index');
    Route::get('/wbs/{wbsNode}', [App\Http\Controllers\WBSController::class, 'show'])->name('wbs.show');

    // Apply EnsureAdminForWrite to all routes in this group to protect write operations
    Route::middleware([EnsureAdminForWrite::class])->group(function () {
        // Production System (Products & WBS)
        Route::resource('products', ProductionSystemController::class);
        Route::post('products/{product}/wbs', [ProductionSystemController::class, 'storeWbsNode'])->name('products.wbs.store');
        Route::delete('wbs/{wbsNode}', [ProductionSystemController::class, 'destroyWbsNode'])->name('wbs.destroy');

        // Planning (BOM & Schedule)
        Route::prefix('planning')->name('planning.')->group(function () {
            Route::get('/bom', [PlanningController::class, 'bom'])->name('bom.index');
            Route::post('/bom', [PlanningController::class, 'storeBom'])->name('bom.store');
            Route::delete('/bom/{bom}', [PlanningController::class, 'destroyBom'])->name('bom.destroy');
            Route::get('/schedule', [PlanningController::class, 'schedule'])->name('schedule.index');
            Route::resource('materials', PlanningController::class);
        });

        // Production Control (Orders)
        Route::resource('orders', ProductionControlController::class);

        // Export Routes (Read-only by nature, but kept here for simplicity, or move out if needed)
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/products', [App\Http\Controllers\ExportController::class, 'products'])->name('products');
            Route::get('/bom', [App\Http\Controllers\ExportController::class, 'bom'])->name('bom');
            Route::get('/schedule', [App\Http\Controllers\ExportController::class, 'schedule'])->name('schedule');
            Route::get('/orders', [App\Http\Controllers\ExportController::class, 'orders'])->name('orders');
            Route::get('/stakeholders', [App\Http\Controllers\ExportController::class, 'stakeholders'])->name('stakeholders');
        });

        // Business Model
        Route::resource('stakeholders', BusinessModelController::class);
    });
});
