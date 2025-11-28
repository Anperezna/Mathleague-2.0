<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preguntas extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'id_pregunta';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_pregunta', 'enunciado', 'id_juego'];

    public function opciones(): HasMany 
    {
        return $this->hasMany(Opciones::class, 'id_pregunta', 'id_pregunta');
    }

    public function juegos(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }
}
