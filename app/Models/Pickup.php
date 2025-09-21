<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    // Campos asignables
    protected $fillable = [
        'user_id',
        'tipo_residuo',     // organico | inorganico | peligroso
        'modalidad',        // null para orgánico/peligroso; 'programada' o 'demanda' para inorgánico
        'direccion',
        'localidad_id',
        'fecha_programada',
        'hora_programada',  // TIME en BD; manejar como string
        'estado',           // por defecto 'programada' en BD
    ];

    // Casts
    protected $casts = [
        'fecha_programada' => 'date',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function localidad()
    {
        return $this->belongsTo(\App\Models\Localidad::class, 'localidad_id');
    }
}
