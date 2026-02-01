<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas públicas
Route::get('/', [App\Http\Controllers\EventoController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('register');
Route::post('/registro', [AuthController::class, 'registro']);

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren login)
Route::middleware('auth')->group(function () {
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');
});

// Rutas de admin (requieren login + ser admin)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/eventos/crear', [AdminController::class, 'crearEvento'])->name('eventos.crear');
    Route::delete('/eventos/{id}', [AdminController::class, 'eliminarEvento'])->name('eventos.eliminar');
});
