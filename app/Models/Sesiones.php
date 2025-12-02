<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sesiones extends Model
{
    protected $table = 'sesionesCompleta';
    protected $primaryKey = 'id_sesion';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_sesion', 'tiempo', 'duracion_sesion', 'intentos', 
    'errores', 'puntos', 'ayuda', 'nivelCompletado', 'id_usuario'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function sesionesJuego(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_sesionCompleta', 'id_sesion');
    }
}
