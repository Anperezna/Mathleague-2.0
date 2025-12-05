<?php

namespace App\Http\Controllers;

use App\Models\Juegos;
use App\Models\Sesiones;
use Illuminate\Http\Request;
use App\Models\Juegos_Sesion;

/**
 * Controlador para la gestión de juegos
 * 
 * Este controlador maneja la visualización de la página de juegos
 * y el sistema de desbloqueo progresivo basado en completitud.
 * 
 * @package App\Http\Controllers
 * @author Math League Team
 * @version 1.0.0
 */
class JuegosController extends Controller
{
    /**
     * Muestra la página principal de juegos con el sistema de desbloqueo
     * 
     * Este método recupera la sesión del usuario autenticado y determina
     * qué juegos han sido completados para mostrar el sistema de desbloqueo
     * progresivo. El primer juego siempre está disponible, y los siguientes
     * se desbloquean al completar el anterior.
     * 
     * @return \Illuminate\View\View Vista de juegos con datos de juegos disponibles y completados
     * 
     * @see \App\Models\Sesiones
     * @see \App\Models\Juegos_Sesion
     */
    public function index()
    {
        $juegosCompletados = [];
        $juegos = [
            ['fondos' => 'mathbus.png', 'ruta' => 'mathbus', 'idJuego' => 1],
            ['fondos' => 'manolo.png', 'ruta' => 'cortacesped', 'idJuego' => 2],
            ['fondos' => 'mathmatch.png', 'ruta' => 'mathmatch', 'idJuego' => 3],
        ];

        // Solo buscar progreso si el usuario está autenticado
        if (auth()->check()) {
            $userId = auth()->id();
            
            // Buscar SOLO la sesión del usuario actual
            $sesion = Sesiones::where('id_usuario', $userId)->first();
            
            // Si el usuario NO tiene sesión, $juegosCompletados queda vacío
            // Solo el juego 1 estará disponible
            if ($sesion) {
                // Obtener SOLO las sesiones de juego completadas de ESTA sesión
                $sesionesJuego = Juegos_Sesion::where('id_sesionCompleta', $sesion->id_sesion)
                    ->where('completado', 1)
                    ->get();
                
                // Agregar los IDs de juegos completados
                foreach ($sesionesJuego as $sj) {
                    $juegosCompletados[] = $sj->id_juego;
                }
                
                \Log::info('Juegos completados para usuario ' . $userId . ': ' . json_encode($juegosCompletados));
            }
        }

        return view('juegos', compact('juegos', 'juegosCompletados'));
    }

    /**
     * Muestra la página del juego Cortacésped
     * 
     * Renderiza la vista del segundo juego de la plataforma.
     * Este juego se desbloquea al completar MathBus.
     * 
     * @return \Illuminate\View\View Vista del juego cortacesped
     */
    public function cortacesped()
    {
        return view('cortacesped');
    }

    /**
     * Muestra la página del juego Entrevista
     * 
     * Renderiza la vista del cuarto juego de la plataforma.
     * Este juego se desbloquea al completar MathMatch.
     * 
     * @return \Illuminate\View\View Vista del juego entrevista
     */
    public function entrevista()
    {
        return view('entrevista');
    }
}
