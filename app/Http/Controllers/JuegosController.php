<?php

namespace App\Http\Controllers;

use App\Models\Sesiones;
use Illuminate\Http\Request;

class JuegosController extends Controller
{
    /**
     * Muestra la página principal de juegos con el sistema de desbloqueo
     */
    public function index()
    {
        $juegosCompletados = [];
        $juegos = [
            ['fondos' => 'mathbus.png', 'ruta' => 'mathbus', 'idJuego' => 1],
            ['fondos' => 'manolo.png', 'ruta' => 'cortacesped', 'idJuego' => 2],
            ['fondos' => 'mathmatch.png', 'ruta' => 'mathmatch', 'idJuego' => 3],
            ['fondos' => 'mathentrevista.png', 'ruta' => 'entrevista', 'idJuego' => 4],
        ];

        if (auth()->check()) {
            $sesion = Sesiones::with('sesionesJuego')
                ->where('id_usuario', auth()->id())
                ->first();
            
            if ($sesion) {
                foreach ($sesion->sesionesJuego as $sj) {
                    if ($sj->completado) {
                        $juegosCompletados[] = $sj->id_juego;
                    }
                }
            }
        }

        return view('juegos', compact('juegos', 'juegosCompletados'));
    }

    /**
     * Muestra la página de cortacésped
     */
    public function cortacesped()
    {
        return view('cortacesped');
    }

    /**
     * Muestra la página de entrevista
     */
    public function entrevista()
    {
        return view('entrevista');
    }
}
