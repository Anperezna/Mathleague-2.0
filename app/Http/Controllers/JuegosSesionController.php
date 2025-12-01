<?php

namespace App\Http\Controllers;

use App\Models\Juegos_Sesion;
use App\Models\Sesiones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class JuegosSesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Juegos_Sesion $juegos_Sesion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Juegos_Sesion $juegos_Sesion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Juegos_Sesion $juegos_Sesion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Juegos_Sesion $juegos_Sesion)
    {
        //
    }

    /**
     * Guardar la sesión del juego
     */
    public function guardarSesion(Request $request)
    {
        $idJuego = $request->id_juego;
        $numeroNivel = 1;
        $completado = 0;
        
        // Configuración específica por juego
        if ($idJuego == 1) { // Mathbus
            $numeroNivel = 1;
            $completado = $request->puntos >= 10 ? 1 : 0;
        } elseif ($idJuego == 2) { // Cortacesped
            $numeroNivel = 2;
            // Logica de juego completado de Cortacesped
        } elseif ($idJuego == 3) { // Mathmatch
            $numeroNivel = 3;
            // Completado cuando se descomponen correctamente 5 números
            $completado = ($request->numerosCompletados ?? 0) >= 5 ? 1 : 0;
        } elseif ($idJuego == 4) { // Entrevista
            $numeroNivel = 4;
            // Logica de juego completado de Entrevista
        }

        Juegos_Sesion::create([
            'numero_nivel' => $numeroNivel,
            'duracion_nivel' => $request->tiempo,
            'completado' => $completado,
            'errores_nivel' => $request->fallos,
            'intentos_nivel' => $request->puntos + $request->fallos,
            'puntuacion' => $request->puntos,
            'id_sesionCompleta' => 1,
            'id_juego' => $idJuego,
        ]);

        return response()->json(['success' => true]);
    }
}
