<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sesiones extends Model
{
    protected $table = 'sesiones';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_sesion', 'date_time', 'sesion_lenght', 'n_attemps', 
    'errores', 'points_scored', 'help_clicks', 'completado', 'id_usuario'];

  
  
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    
    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }

   
    public function juegosSesion(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_sesion', 'id_sesion');
    }
}
