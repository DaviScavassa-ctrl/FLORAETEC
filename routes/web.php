<?php

use App\Http\Controllers\PlantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — PlantCare
|--------------------------------------------------------------------------
*/

// Rota raiz → redireciona para o catálogo
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard / Catálogo (protegido por autenticação)
Route::get('/dashboard', [PlantController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// CRUD de plantas (protegido por autenticação)
Route::middleware('auth')->group(function () {
    Route::resource('plants', PlantController::class);

    // Rotas de perfil geradas pelo Breeze
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas de autenticação geradas pelo Breeze (login, register, etc.)
require __DIR__ . '/auth.php';
