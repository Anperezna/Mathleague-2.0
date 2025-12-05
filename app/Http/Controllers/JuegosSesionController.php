<?php

namespace App\Http\Controllers;

use App\Models\Juegos_Sesion;
use App\Models\Sesiones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

/**
 * Controlador para la gestión de sesiones de juego
 * 
 * Maneja el almacenamiento y actualización de las sesiones de juego,
 * incluyendo puntuaciones, tiempos, errores y estado de completitud.
 * Implementa el sistema de desbloqueo progresivo marcando juegos como completados.
 * 
 * @package App\Http\Controllers
 * @author Math League Team
 * @version 1.0.0
 */
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
     * Guarda o actualiza la sesión de juego del usuario autenticado
     * 
     * Este método procesa los datos enviados desde los juegos JavaScript y los
     * almacena en la base de datos. Implementa la lógica de completitud específica
     * para cada juego:
     * - MathBus (id 1): Completado con 10+ puntos
     * - Cortacesped (id 2): Lógica pendiente
     * - MathMatch (id 3): Completado con 5+ números factorizados
     * - Entrevista (id 4): Lógica pendiente
     * 
     * Usa updateOrCreate para evitar duplicados, actualizando el registro existente
     * si el usuario ya jugó ese juego o creando uno nuevo en caso contrario.
     * 
     * @param \Illuminate\Http\Request $request Solicitud con datos del juego:
     *                                          - id_juego: ID del juego (1-4)
     *                                          - tiempo: Duración de la partida en segundos
     *                                          - puntos: Puntuación obtenida
     *                                          - fallos: Número de errores cometidos
     *                                          - intentos: Número total de intentos (opcional)
     *                                          - numerosCompletados: Números factorizados (MathMatch)
     * 
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con success: true
     * 
     * @see \App\Models\Sesiones
     * @see \App\Models\Juegos_Sesion
     */
    public function guardarSesion(Request $request)
    {
        $idJuego = $request->id_juego;
        $numeroNivel = 1;
        $completado = 0;
        
        // Configuración específica por juego
        if ($idJuego == 1) {
            $numeroNivel = 1;
            $completado = $request->puntos >= 10 ? 1 : 0;
        } elseif ($idJuego == 2) {
            $numeroNivel = 2;
            $completado = ($request->aciertos ?? 0) >= 6 ? 1 : 0;
        } elseif ($idJuego == 3) {
            $numeroNivel = 3;
            // Completado cuando se descomponen correctamente 4 números
            $completado = ($request->numerosCompletados ?? 0) >= 4 ? 1 : 0;
        } elseif ($idJuego == 4) { // Entrevista
            $numeroNivel = 4;
            // Logica de juego completado de Entrevista
        }

        // Obtener o crear una sesión completa para el usuario autenticado
        $sesion = Sesiones::firstOrCreate(
            ['id_usuario' => auth()->id()],
            [
                'tiempo' => now(),
                'duracion_sesion' => 0,
                'intentos' => 0,
                'errores' => 0,
                'puntos' => 0,
                'ayuda' => 0,
                'nivelCompletado' => 0
            ]
        );

        // Usar updateOrCreate para actualizar si existe o crear si no existe
        Juegos_Sesion::updateOrCreate(
            [
                'id_sesionCompleta' => $sesion->id_sesion,
                'id_juego' => $idJuego,
            ],
            [
                'numero_nivel' => $numeroNivel,
                'duracion_nivel' => $request->tiempo,
                'completado' => $completado,
                'errores_nivel' => $request->errores ?? $request->fallos ?? 0,
                'intentos_nivel' => $request->intentos ?? (($request->aciertos ?? 0) + ($request->errores ?? $request->fallos ?? 0)),
                'puntuacion' => $request->puntos ?? 0,
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Guarda los datos completos de una sesión cuando se completan los 3 juegos
     * 
     * @param \Illuminate\Http\Request $request Solicitud con datos acumulados de los 3 juegos
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con success: true
     */
    public function guardarSesionCompleta(Request $request)
    {
        // Obtener o crear una sesión completa para el usuario autenticado
        $sesion = Sesiones::firstOrCreate(
            ['id_usuario' => auth()->id()],
            [
                'tiempo' => now(),
                'duracion_sesion' => 0,
                'intentos' => 0,
                'errores' => 0,
                'puntos' => 0,
                'ayuda' => 0,
                'nivelCompletado' => 0
            ]
        );

        // Actualizar con los datos acumulados de los 3 juegos
        $sesion->update([
            'duracion_sesion' => $request->tiempo_total ?? 0,
            'intentos' => $request->intentos_total ?? 0,
            'errores' => $request->errores_total ?? 0,
            'puntos' => $request->puntos_total ?? 0,
            'ayuda' => $request->ayuda_total ?? 0,
            'nivelCompletado' => $request->juegos_completados ?? 0
        ]);

        return response()->json(['success' => true, 'message' => 'Sesión completa guardada correctamente']);
    }
}
