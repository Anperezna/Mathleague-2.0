<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MathmatchController extends Controller
{
    /**
     * Mostrar la vista del juego
     */
    public function index()
    {
        return view('mathmatch');
    }
}
