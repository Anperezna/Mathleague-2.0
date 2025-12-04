<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Juegos
 * 
 * Representa los juegos disponibles en la plataforma Math League.
 * Cada juego tiene preguntas asociadas y sesiones de juego de usuarios.
 * 
 * @package App\Models
 * @author Math League Team
 * @version 1.0.0
 * 
 * @property int $id_juego Identificador único del juego
 * @property string $nombre Nombre del juego (MathBus, MathMatch, etc.)
 * @property int $orden Orden de aparición en la interfaz
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sesiones[] $sesionesCompleta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Juegos_Sesion[] $sesionesJuego
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Preguntas[] $preguntas
 */
class Juegos extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id_juego';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_juego', 'nombre', 'orden'];

    /**
     * Obtiene todas las sesiones completas asociadas (relación legacy)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesionesCompleta(): HasMany
    {
        return $this->hasMany(Sesiones::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene todas las sesiones de juego de este juego
     * 
     * Relación uno a muchos: Un juego tiene múltiples sesiones de juego
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesionesJuego(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_juego', 'id_juego');
    }

    /**
     * Obtiene todas las preguntas asociadas a este juego
     * 
     * Relación uno a muchos: Un juego tiene múltiples preguntas
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preguntas(): HasMany
    {
        return $this->hasMany(Preguntas::class, 'id_juego', 'id_juego');
    }
}
