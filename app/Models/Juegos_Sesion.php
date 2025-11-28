<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Juegos_Sesion extends Model
{
    protected $table = 'sesionesJuego';
    protected $primaryKey = 'id_juegos_sesion';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_juegos_sesion', 'numero_nivel', 'duracion_nivel', 'completado', 
    'errores_nivel', 'intentos_nivel', 'puntuacion', 'id_sesionCompleta', 'id_juego'];

    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }
    
    public function sesionCompleta(): BelongsTo
    {
        return $this->belongsTo(Sesiones::class, 'id_sesionCompleta', 'id_sesion');
    }
}
