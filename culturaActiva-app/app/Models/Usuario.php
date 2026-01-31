<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // Nombre de tu tabla
    protected $primaryKey = 'id_usuario'; // Tu clave primaria
    public $timestamps = false; // No usas created_at/updated_at

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'contrasena',
        'rol',
        'activo'
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Laravel espera 'password', pero tu campo se llama 'contrasena'
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
