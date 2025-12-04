<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Sesiones
 * 
 * Representa una sesión completa de juego de un usuario.
 * Almacena estadísticas generales y se relaciona con sesiones individuales de cada juego.
 * 
 * @package App\Models
 * @author Math League Team
 * @version 1.0.0
 * 
 * @property int $id_sesion Identificador único de la sesión
 * @property string $tiempo Fecha y hora de inicio de la sesión
 * @property int $duracion_sesion Duración total en segundos
 * @property int $intentos Número total de intentos
 * @property int $errores Número total de errores
 * @property int $puntos Puntuación total acumulada
 * @property int $ayuda Número de ayudas utilizadas
 * @property int $nivelCompletado Último nivel completado
 * @property int $id_usuario ID del usuario propietario
 * 
 * @property-read \App\Models\Usuario $usuario
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Juegos_Sesion[] $sesionesJuego
 */
class Sesiones extends Model
{
    protected $table = 'sesionesCompleta';
    protected $primaryKey = 'id_sesion';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_sesion', 'tiempo', 'duracion_sesion', 'intentos', 
    'errores', 'puntos', 'ayuda', 'nivelCompletado', 'id_usuario'];

    /**
     * Obtiene el usuario propietario de esta sesión
     * 
     * Relación muchos a uno: Muchas sesiones pertenecen a un usuario
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene todas las sesiones de juegos individuales
     * 
     * Relación uno a muchos: Una sesión completa tiene múltiples sesiones de juego
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesionesJuego(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_sesionCompleta', 'id_sesion');
    }
}
