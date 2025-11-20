<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/', function () {
    return view('login');
});

Route::get('/', function () {
    return view('register');
});

Route::get('/', function () {
    return view('mathbus');
});

Route::get('/', function () {
    return view('mathmatch');
});

Route::get('/', function () {
    return view('cortacesped');
});

Route::get('/', function () {
    return view('entrevista');
});

Route::get('/', function () {
    return view('perfil');
});

Route::get('/', function () {
    return view('juegos');
});
