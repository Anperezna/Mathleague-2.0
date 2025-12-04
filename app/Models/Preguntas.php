<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Preguntas
 * 
 * Representa las preguntas matemáticas de cada juego.
 * Cada pregunta tiene múltiples opciones de respuesta asociadas.
 * 
 * @package App\Models
 * @author Math League Team
 * @version 1.0.0
 * 
 * @property int $id_pregunta Identificador único de la pregunta
 * @property string $enunciado Texto de la pregunta o problema matemático
 * @property int $id_juego ID del juego al que pertenece
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Opciones[] $opciones
 * @property-read \App\Models\Juegos $juegos
 */
class Preguntas extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'id_pregunta';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_pregunta', 'enunciado', 'id_juego'];

    /**
     * Obtiene todas las opciones de respuesta de esta pregunta
     * 
     * Relación uno a muchos: Una pregunta tiene múltiples opciones
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opciones(): HasMany 
    {
        return $this->hasMany(Opciones::class, 'id_pregunta', 'id_pregunta');
    }

    /**
     * Obtiene el juego al que pertenece esta pregunta
     * 
     * Relación muchos a uno: Muchas preguntas pertenecen a un juego
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function juegos(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }
}
