<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opciones extends Model
{
    protected $table = 'opciones';
    public $incrementing = true;
    public $timestamps = false;

    public function preguntas(): BelongsTo
    {
        return $this->belongsTo(Preguntas::class, 'id_pregunta', 'id_pregunta');
    }
}
