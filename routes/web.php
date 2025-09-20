<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\AdminController;

// Ruta inicial
Route::get('/', function () {
    return view('welcome');
});

// Ruta para el dashboard de usuario
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Agrupamos las rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    // Rutas para el perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para las recolecciones (permitidas para usuarios autenticados)
    Route::resource('pickups', PickupController::class);
});

// Rutas para administradores, aplicando el middleware 'admin'
Route::middleware(['auth', 'admin'])->group(function () {
    // Ruta para ver todos los usuarios
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users'); 

    // Ruta para descargar informes de los usuarios
    Route::get('/admin/reports', [AdminController::class, 'downloadReport'])->name('admin.downloadReport'); 

    // Ruta para gestionar las recolecciones
    Route::get('/admin/pickups', [AdminController::class, 'managePickups'])->name('admin.managePickups');
    
    // Ruta para exportar usuarios a CSV
    Route::get('/admin/export', [AdminController::class, 'exportUsersCsv'])->name('admin.exportCsv'); 

    // 👇 RUTA AÑADIDA PARA SOLUCIONAR EL ERROR 👇
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.editUser');
});

require __DIR__.'/auth.php';

