<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atributos asignables en masa.
     *
     * Importante: incluir los campos extra que agregaste en la migración.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cedula',
        'direccion',
        'telefono',
        'localidad_id',
        'role', // Agregado 'role' para el control de roles
    ];

    /**
     * Atributos ocultos para serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: un usuario pertenece a una localidad.
     */
    public function localidad()
    {
        return $this->belongsTo(\App\Models\Localidad::class);
    }

    /**
     * Método para verificar si el usuario es admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin'; // Verifica si el rol del usuario es 'admin'
    }
}
