<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Sesiones;
use App\Models\Juegos_Sesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Mostrar el perfil del usuario con sus estadísticas de juegos
     * 
     * Consulta las estadísticas de todos los juegos jugados por el usuario
     * desde la base de datos y las pasa a la vista de perfil.
     * 
     * @return \Illuminate\View\View
     */
    public function perfil()
    {
        $userId = auth()->id();
        
        // Obtener la sesión del usuario
        $sesion = Sesiones::where('id_usuario', $userId)->first();
        
        // Si el usuario no tiene sesiones, mostrar estadísticas vacías
        if (!$sesion) {
            return view('perfil', [
                'juegos' => [],
                'estadisticasJuegos' => collect([])
            ]);
        }
        
        // Obtener todas las estadísticas de juegos de este usuario
        $estadisticasJuegos = Juegos_Sesion::where('id_sesionCompleta', $sesion->id_sesion)
            ->with('juego')
            ->get()
            ->keyBy('id_juego'); // Indexar por ID de juego para fácil acceso
        
        // Definir estructura de juegos con sus estadísticas
        $juegos = [
            [
                'id' => 1,
                'title' => 'El Autobús',
                'image' => 'img/juegos/mathbus.png',
                'partidas' => $estadisticasJuegos->get(1)?->intentos_nivel ?? 0,
                'mejorTiempo' => $this->formatTiempo($estadisticasJuegos->get(1)?->duracion_nivel ?? 0),
                'aciertos' => $estadisticasJuegos->get(1)?->puntuacion ?? 0,
                'errores' => $estadisticasJuegos->get(1)?->errores_nivel ?? 0,
            ],
            [
                'id' => 2,
                'title' => 'Paco y la Cortacésped',
                'image' => 'img/juegos/manolo.png',
                'partidas' => $estadisticasJuegos->get(2)?->intentos_nivel ?? 0,
                'mejorTiempo' => $this->formatTiempo($estadisticasJuegos->get(2)?->duracion_nivel ?? 0),
                'aciertos' => $estadisticasJuegos->get(2)?->puntuacion ?? 0,
                'errores' => $estadisticasJuegos->get(2)?->errores_nivel ?? 0,
            ],
            [
                'id' => 3,
                'title' => 'Partido de Fútbol',
                'image' => 'img/juegos/mathmatch.png',
                'partidas' => $estadisticasJuegos->get(3)?->intentos_nivel ?? 0,
                'mejorTiempo' => $this->formatTiempo($estadisticasJuegos->get(3)?->duracion_nivel ?? 0),
                'aciertos' => $estadisticasJuegos->get(3)?->puntuacion ?? 0,
                'errores' => $estadisticasJuegos->get(3)?->errores_nivel ?? 0,
            ],
        ];
        
        return view('perfil', compact('juegos'));
    }
    
    /**
     * Formatear tiempo en segundos a formato MM:SS
     * 
     * @param int $segundos
     * @return string
     */
    private function formatTiempo($segundos)
    {
        if (!$segundos) return '--:--';
        
        $minutos = floor($segundos / 60);
        $segs = $segundos % 60;
        
        return sprintf('%02d:%02d', $minutos, $segs);
    }

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
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
