<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;

// ----------------------
// Página de bienvenida
// ----------------------
Route::get('/', function () {
    return view('welcome');
});

// ----------------------
// Rutas para usuarios autenticados
// ----------------------
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard de usuario (lista de canchas disponibles)
    Route::get('/dashboard', [CanchaController::class, 'index'])->name('dashboard');

    // Canchas (crear cancha) → realmente solo debería usarse desde admin
    Route::post('/canchas', [CanchaController::class, 'store'])->name('canchas.store');

    // Reservas (usuario crea sus reservas)
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas'])->name('reservas.mis'); // 👈 para que cada usuario vea sus reservas

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----------------------
// ADMIN
// ----------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminReservaController::class, 'index'])->name('dashboard');

        // Reservas
        Route::get('/reservas', [AdminReservaController::class, 'index'])->name('reservas.index');
        Route::patch('/reservas/{id}/estado', [AdminReservaController::class, 'updateEstado'])->name('reservas.updateEstado');

        // Canchas
        Route::get('/canchas/{cancha}/edit', [CanchaController::class, 'edit'])->name('canchas.edit');
        Route::put('/canchas/{cancha}', [CanchaController::class, 'update'])->name('canchas.update');
        Route::delete('/canchas/{cancha}', [CanchaController::class, 'destroy'])->name('canchas.destroy');
        Route::post('/canchas', [CanchaController::class, 'store'])->name('canchas.store');

        // Canchas por deporte (ADMIN)
        Route::get('/futbol', [CanchaController::class, 'futbol'])->name('futbol');
        Route::get('/basketball', [CanchaController::class, 'basketball'])->name('basketball');
        Route::get('/tenis', [CanchaController::class, 'tenis'])->name('tenis');
    });

// ----------------------
// USUARIO
// ----------------------
Route::middleware(['auth', 'role:user'])
    ->prefix('usuario')
    ->name('user.')
    ->group(function () {
        Route::get('/', [CanchaController::class, 'index'])->name('dashboard');
        Route::get('/reservas', [ReservaController::class, 'misReservas'])->name('reservas.index');

        // Canchas por deporte (USUARIO)

        Route::get('/futbol', [CanchaController::class, 'userFutbol'])->name('futbol');
        Route::get('/basketball', [CanchaController::class, 'userBasketball'])->name('basketball');
        Route::get('/tenis', [CanchaController::class, 'userTenis'])->name('tenis');

    });


    // Alias global para fútbol
Route::middleware(['auth', 'verified'])->get('/futbol', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.futbol');
    } else {
        return redirect()->route('user.futbol');
    }
})->name('futbol');

// Alias global para basketball
Route::middleware(['auth', 'verified'])->get('/basketball', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.basketball');
    } else {
        return redirect()->route('user.basketball');
    }
})->name('basketball');

// Alias global para tenis
Route::middleware(['auth', 'verified'])->get('/tenis', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.tenis');
    } else {
        return redirect()->route('user.tenis');
    }
})->name('tenis');

require __DIR__.'/auth.php';