<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\AdminController;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('pickups/export', [PickupController::class, 'export'])->name('pickups.export');
    Route::resource('pickups', PickupController::class)->except(['show']);
    
});

Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('users',             [AdminController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::patch('users/{user}',    [AdminController::class, 'update'])->name('users.update');

        Route::get('pickups',        [AdminController::class, 'managePickups'])->name('pickups.index');
        Route::get('pickups/export', [AdminController::class, 'exportPickupsCsv'])->name('pickups.export');
    });

require __DIR__.'/auth.php';
