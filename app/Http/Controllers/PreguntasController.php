<?php

namespace App\Http\Controllers;

use App\Models\Preguntas;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idJuego)
    {
        // 
        $preguntas = Preguntas::where('id_juego', $idJuego)->get();
        return view('mathbus', compact('preguntas'));
    }

    /**
     * Obtener preguntas para MathMatch (id_juego = 3) con opciones
     */
    public function getPreguntasMathmatch()
    {
        $preguntas = Preguntas::with('opciones')
            ->where('id_juego', 3)
            ->inRandomOrder()
            ->get()
            ->map(function ($pregunta) {
                $opciones = $pregunta->opciones->first();
                
                return [
                    'id_pregunta' => $pregunta->id_pregunta,
                    'enunciado' => $pregunta->enunciado,
                    'opciones' => [
                        'opcion1' => $opciones->opcion1,
                        'opcion2' => $opciones->opcion2,
                        'opcion3' => $opciones->opcion3,
                        'opcion4' => $opciones->opcion4,
                    ],
                    'solucion_correcta' => $opciones->esCorrecta
                ];
            });

        return response()->json([
            'success' => true,
            'preguntas' => $preguntas
        ]);
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
}
