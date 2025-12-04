<?php

namespace App\Http\Controllers;

use App\Models\Preguntas;
use App\Models\Juegos;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de preguntas de juegos
 * 
 * Este controlador se encarga de cargar las preguntas asociadas a cada juego
 * junto con sus opciones de respuesta desde la base de datos y pasarlas
 * a las vistas correspondientes.
 * 
 * @package App\Http\Controllers
 * @author Math League Team
 * @version 1.0.0
 */
class PreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idJuego)
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
    public function show(Preguntas $preguntas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preguntas $preguntas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preguntas $preguntas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preguntas $preguntas)
    {
        //
    }

    /**
     * Carga y muestra el juego MathBus con sus preguntas
     * 
     * Recupera el juego MathBus de la base de datos junto con todas sus
     * preguntas y opciones asociadas. Las preguntas se cargan en orden
     * aleatorio para cada sesión de juego. Inyecta los datos en la vista
     * usando Blade para evitar llamadas API.
     * 
     * @return \Illuminate\View\View Vista mathbus con las preguntas en formato JSON
     * 
     * @see \App\Models\Juegos
     * @see \App\Models\Preguntas
     * @see \App\Models\Opciones
     */
    public function mathbus()
    {
        // Traemos el juego Mathbus con todas sus preguntas y opciones asociadas
        $juego = Juegos::with(['preguntas' => function($query) {
            $query->inRandomOrder();
        }, 'preguntas.opciones'])->where('nombre', 'Mathbus')->first();

        $preguntas = $juego ? $juego->preguntas : collect();

        // Retornamos la vista con las preguntas y opciones
        return view('mathbus', compact('preguntas'));
    }

    /**
     * Carga y muestra el juego MathMatch con sus preguntas
     * 
     * Recupera el juego MathMatch de la base de datos junto con todas sus
     * preguntas y opciones asociadas. Las preguntas se cargan en orden
     * aleatorio para cada sesión de juego. Inyecta los datos en la vista
     * usando Blade para evitar llamadas API.
     * 
     * @return \Illuminate\View\View Vista mathmatch con las preguntas en formato JSON
     * 
     * @see \App\Models\Juegos
     * @see \App\Models\Preguntas
     * @see \App\Models\Opciones
     */
    public function mathmatch()
    {
        // Traemos el juego MathMatch con todas sus preguntas y opciones asociadas
        $juego = Juegos::with(['preguntas' => function($query) {
            $query->inRandomOrder();
        }, 'preguntas.opciones'])->where('nombre', 'MathMatch')->first();

        $preguntas = $juego ? $juego->preguntas : collect();

        // Retornamos la vista con las preguntas y opciones
        return view('mathmatch', compact('preguntas'));
    }
}
