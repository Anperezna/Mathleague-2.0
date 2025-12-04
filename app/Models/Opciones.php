<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Opciones
 * 
 * Representa las opciones de respuesta de una pregunta.
 * Cada registro almacena hasta 4 opciones y cuál es la correcta.
 * 
 * @package App\Models
 * @author Math League Team
 * @version 1.0.0
 * 
 * @property int $id_opcion Identificador único de las opciones
 * @property string $opcion1 Primera opción de respuesta
 * @property string $opcion2 Segunda opción de respuesta
 * @property string $opcion3 Tercera opción de respuesta
 * @property string $opcion4 Cuarta opción de respuesta
 * @property int $esCorrecta Número de la opción correcta (1-4)
 * @property int $id_pregunta ID de la pregunta asociada
 * 
 * @property-read \App\Models\Preguntas $preguntas
 */
class Opciones extends Model
{
    protected $table = 'opciones';
    protected $primaryKey = 'id_opcion';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_opcion', 'opcion1', 'opcion2', 'opcion3', 'opcion4', 'esCorrecta', 'id_pregunta'];

    /**
     * Obtiene la pregunta a la que pertenecen estas opciones
     * 
     * Relación muchos a uno: Muchas opciones pertenecen a una pregunta
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function preguntas(): BelongsTo
    {
        return $this->belongsTo(Preguntas::class, 'id_pregunta', 'id_pregunta');
    }
}
