<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Sesiones;
use App\Models\Juegos_Sesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador para la gestión del ranking global
 * 
 * Maneja la obtención y visualización de estadísticas de usuarios
 * ordenadas por puntuación total y precisión.
 * 
 * @package App\Http\Controllers
 * @author Math League Team
 * @version 1.0.0
 */
class RankingController extends Controller
{
    /**
     * Muestra el ranking global de todos los usuarios
     * 
     * Obtiene todos los usuarios con sus sesiones y sesiones de juego usando Eloquent,
     * calcula puntos totales y ordena de forma descendente por puntuación.
     * Permite filtrar por juego específico mediante el parámetro $idJuego.
     * 
     * @param \Illuminate\Http\Request $request Solicitud HTTP con parámetro opcional 'juego'
     * @return \Illuminate\View\View Vista del ranking con datos ordenados
     * 
     * @see \App\Models\Usuario
     * @see \App\Models\Sesiones
     * @see \App\Models\Juegos_Sesion
     */
    public function index(Request $request)
    {
        $idJuego = $request->query('juego'); // null, 1, 2, o 3

        // Obtener todos los usuarios con sus sesiones y juegos usando Eloquent
        $rankings = Usuario::with(['sesiones.sesionesJuego'])
            ->get()
            ->map(function ($usuario) use ($idJuego) {
                // Calcular puntos totales del usuario
                $totalPuntos = 0;

                foreach ($usuario->sesiones as $sesion) {
                    foreach ($sesion->sesionesJuego as $juegoSesion) {
                        // Si hay filtro de juego, solo sumar puntos de ese juego
                        if ($idJuego === null || $juegoSesion->id_juego == $idJuego) {
                            $totalPuntos += $juegoSesion->puntuacion ?? 0;
                        }
                    }
                }

                return [
                    'username' => $usuario->username,
                    'points' => $totalPuntos,
                ];
            })
            // Filtrar usuarios que no han jugado
            ->filter(function ($user) {
                return $user['points'] > 0;
            })
            // Ordenar por puntos de forma descendente
            ->sortByDesc('points')
            ->values()
            // Agregar posición
            ->map(function ($user, $index) {
                $user['position'] = $index + 1;
                $user['medal'] = $index === 0 ? '🥇' : ($index === 1 ? '🥈' : ($index === 2 ? '🥉' : ''));
                return $user;
            });

        // Calcular estadísticas globales
        $totalJugadores = $rankings->count();
        $totalPuntos = $rankings->sum('points');

        return view('ranking', compact('rankings', 'totalJugadores', 'totalPuntos', 'idJuego'));
    }
}
