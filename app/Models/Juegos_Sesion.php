<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Juegos_Sesion
 * 
 * Representa la sesión de juego de un usuario para un juego específico.
 * Almacena estadísticas individuales y el estado de completitud que controla
 * el sistema de desbloqueo progresivo.
 * 
 * @package App\Models
 * @author Math League Team
 * @version 1.0.0
 * 
 * @property int $id_juegos_sesion Identificador único de la sesión de juego
 * @property int $numero_nivel Número del nivel jugado
 * @property int $duracion_nivel Duración en segundos
 * @property int $completado Estado de completitud (0 = no completado, 1 = completado)
 * @property int $errores_nivel Número de errores cometidos
 * @property int $intentos_nivel Número total de intentos
 * @property int $puntuacion Puntuación obtenida
 * @property int $id_sesionCompleta ID de la sesión completa padre
 * @property int $id_juego ID del juego jugado
 * 
 * @property-read \App\Models\Juegos $juego
 * @property-read \App\Models\Sesiones $sesionCompleta
 */
class Juegos_Sesion extends Model
{
    protected $table = 'sesionesJuego';
    protected $primaryKey = 'id_juegos_sesion';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_juegos_sesion', 'numero_nivel', 'duracion_nivel', 'completado', 
    'errores_nivel', 'intentos_nivel', 'puntuacion', 'id_sesionCompleta', 'id_juego'];

    /**
     * Obtiene el juego asociado a esta sesión
     * 
     * Relación muchos a uno: Muchas sesiones de juego pertenecen a un juego
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }
    
    /**
     * Obtiene la sesión completa padre
     * 
     * Relación muchos a uno: Muchas sesiones de juego pertenecen a una sesión completa
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesionCompleta(): BelongsTo
    {
        return $this->belongsTo(Sesiones::class, 'id_sesionCompleta', 'id_sesion');
    }
}
