<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MathmatchController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\CortacespedController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/mathbus', [PreguntasController::class, 'mathbus'])->name('mathbus');

Route::get('/mathmatch', [MathmatchController::class, 'index'])->name('mathmatch');
Route::get('/api/mathmatch/questions', [PreguntasController::class, 'getPreguntasMathmatch'])->name('mathmatch.questions');

Route::get('/cortacesped', function () {
    return view('cortacesped');
})->name('cortacesped');

// Rutas API para Cortacésped
Route::post('/api/cortacesped/guardar', [CortacespedController::class, 'guardarResultado'])->name('cortacesped.guardar');
Route::get('/api/cortacesped/ranking', [CortacespedController::class, 'obtenerRanking'])->name('cortacesped.ranking');

Route::get('/entrevista', function () {
    return view('entrevista');
})->name('entrevista');

Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

Route::get('/juegos', function () {
    return view('juegos');
})->name('juegos');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/aprendizaje', function () {
    return view('aprendizaje');
})->name('aprendizaje');