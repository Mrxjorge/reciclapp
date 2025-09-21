<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\AdminController;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('pickups', PickupController::class);
});

Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Usuarios
        Route::get('users',             [AdminController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::patch('users/{user}',    [AdminController::class, 'update'])->name('users.update');

        // Recolecciones
        Route::get('pickups',           [AdminController::class, 'managePickups'])->name('pickups.index');
        Route::get('pickups/export',    [AdminController::class, 'exportPickupsCsv'])->name('pickups.export');
    });

// Route::get('pickups/export', [AdminController::class, 'exportPickupsCsv'])->name('pickups.export');

require __DIR__.'/auth.php';
