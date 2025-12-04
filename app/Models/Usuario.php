<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo Usuario
 * 
 * Representa a los usuarios registrados en la plataforma Math League.
 * Extiende de Authenticatable para soportar autenticación de Laravel.
 * 
 * @package App\Models
 * @author Math League Team
 * @version 1.0.0
 * 
 * @property int $id_usuario Identificador único del usuario
 * @property string $username Nombre de usuario (único)
 * @property string $email Correo electrónico (único)
 * @property string $contrasena Contraseña hasheada
 * @property string $fecha_registro Fecha y hora de registro
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sesiones[] $sesiones
 */
class Usuario extends Authenticatable

{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['id_usuario', 'username', 'email', 'contrasena', 'fecha_registro'];

    /**
     * Obtiene todas las sesiones completas del usuario
     * 
     * Relación uno a muchos: Un usuario puede tener múltiples sesiones
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesiones(): HasMany
    {
        return $this->hasMany(Sesiones::class, 'id_usuario', 'id_usuario');
    }
}
