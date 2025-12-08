<?php

use App\Http\Controllers\CortacespedController;
use App\Http\Controllers\JuegosController;
use App\Http\Controllers\JuegosSesionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('register');
})->name('index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Rutas protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/mathbus', [PreguntasController::class, 'mathbus'])->name('mathbus');
    Route::post('/guardar-sesion', [JuegosSesionController::class, 'guardarSesion'])->name('guardar.sesion');

    Route::get('/mathmatch', [PreguntasController::class, 'mathmatch'])->name('mathmatch');

    Route::get('/cortacesped', [JuegosController::class, 'cortacesped'])->name('cortacesped');

    // Rutas API para Cortacésped
    Route::post('/api/cortacesped/guardar', [CortacespedController::class, 'guardarResultado'])->name('cortacesped.guardar');
    Route::get('/api/cortacesped/ranking', [CortacespedController::class, 'obtenerRanking'])->name('cortacesped.ranking');

    Route::get('/entrevista', [JuegosController::class, 'entrevista'])->name('entrevista');

    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');

    Route::get('/juegos', [JuegosController::class, 'index'])->name('juegos');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');
});
