<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Juegos_Sesion extends Model
{
    protected $table = 'juegos_sesion';
    public $incrementing = true;
    public $timestamps = false;
    

    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }
    
  
    public function sesion(): BelongsTo
    {
        return $this->belongsTo(Sesiones::class, 'id_sesion', 'id_sesion');
    }

}
