<?php

use App\Models\Sesiones;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MathmatchController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\JuegosSesionController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/mathbus', [PreguntasController::class, 'mathbus'])->name('mathbus');
Route::post('/guardar-sesion', [JuegosSesionController::class, 'guardarSesion'])->name('guardar.sesion');

Route::get('/mathmatch', [PreguntasController::class, 'mathmatch'])->name('mathmatch');

Route::get('/cortacesped', function () {
    return view('cortacesped');
})->name('cortacesped');

Route::get('/entrevista', function () {
    return view('entrevista');
})->name('entrevista');

Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

Route::get('/juegos', function () {
    // Obtener juegos completados por el usuario autenticado
    $juegosCompletados = [];
    $juegos = [
        ['fondos' => 'mathbus.png', 'ruta' => 'mathbus', 'idJuego' => 1],
        ['fondos' => 'manolo.png', 'ruta' => 'cortacesped', 'idJuego' => 2],
        ['fondos' => 'mathmatch.png', 'ruta' => 'mathmatch', 'idJuego' => 3],
        ['fondos' => 'mathentrevista.png', 'ruta' => 'entrevista', 'idJuego' => 4],
    ];

    if(auth()->check()){
        $sesion = Sesiones::with('sesionesJuego')->where('id_usuario', auth()->id())->first();
        foreach($sesion->sesionesJuego as $sj){
            if($sj->completado){
                $juegosCompletados[] = $sj->id_juego;
            }
        }
    }

     


    return view('juegos', compact('juegos','juegosCompletados'));
})->name('juegos');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/aprendizaje', function () {
    return view('aprendizaje');
})->name('aprendizaje');