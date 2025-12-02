<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opciones extends Model
{
    protected $table = 'opciones';
    protected $primaryKey = 'id_opcion';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = ['id_opcion', 'opcion1', 'opcion2', 'opcion3', 'opcion4', 'esCorrecta', 'id_pregunta'];

    public function preguntas(): BelongsTo
    {
        return $this->belongsTo(Preguntas::class, 'id_pregunta', 'id_pregunta');
    }
}
