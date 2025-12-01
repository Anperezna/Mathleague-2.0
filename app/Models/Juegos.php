<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Juegos extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id_juego';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_juego', 'nombre', 'orden'];

    public function sesionesCompleta(): HasMany
    {
        return $this->hasMany(Sesiones::class, 'id_usuario', 'id_usuario');
    }

    public function sesionesJuego(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_juego', 'id_juego');
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(Preguntas::class, 'id_juego', 'id_juego');
    }
}
