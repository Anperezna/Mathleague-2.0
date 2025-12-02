<?php

namespace App\Http\Controllers;

use App\Models\Juegos_Sesion;
use App\Models\Sesiones;
use Illuminate\Http\Request;

class CortacespedController extends Controller
{
    /**
     * Guardar los resultados del juego Cortacésped
     */
    public function guardarResultado(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'puntuacion' => 'required|integer',
            'tiempo_jugado' => 'required|integer',
            'cesped_cortado' => 'required|integer',
        ]);

        // Obtener el usuario de la sesión
        $userId = session('id_usuario');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        // Crear una sesión completa
        $sesion = Sesiones::create([
            'fecha' => now(),
            'id_usuario' => $userId
        ]);

        // Buscar el ID del juego Cortacésped (asumiendo id_juego = 3)
        $idJuego = 3; // Ajusta según tu base de datos

        // Guardar el resultado del juego
        $juegoSesion = Juegos_Sesion::create([
            'numero_nivel' => 1,
            'duracion_nivel' => $request->tiempo_jugado,
            'completado' => 1,
            'errores_nivel' => 0,
            'intentos_nivel' => 1,
            'puntuacion' => $request->puntuacion,
            'id_sesionCompleta' => $sesion->id_sesion,
            'id_juego' => $idJuego
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resultado guardado correctamente',
            'data' => [
                'id_sesion' => $juegoSesion->id_juegos_sesion,
                'puntuacion' => $juegoSesion->puntuacion
            ]
        ]);
    }

    /**
     * Obtener el ranking de mejores puntuaciones
     */
    public function obtenerRanking()
    {
        $idJuego = 3; // ID del juego Cortacésped

        $ranking = Juegos_Sesion::where('id_juego', $idJuego)
            ->with(['sesionCompleta.usuario'])
            ->orderBy('puntuacion', 'desc')
            ->take(10)
            ->get()
            ->map(function($sesion) {
                return [
                    'puntuacion' => $sesion->puntuacion,
                    'duracion' => $sesion->duracion_nivel,
                    'fecha' => $sesion->sesionCompleta->fecha,
                    'usuario' => $sesion->sesionCompleta->usuario->nombre ?? 'Anónimo'
                ];
            });

        return response()->json([
            'success' => true,
            'ranking' => $ranking
        ]);
    }
}
