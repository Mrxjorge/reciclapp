<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    // Campos que se pueden asignar en masa desde los formularios
    protected $fillable = [
        'user_id',
        'tipo_residuo',
        'modalidad',          // default 'programada' en BD
        'fecha_programada',
        'hora_programada',
        'estado',             // default 'programada' en BD
    ];

    // Casts útiles para manejar fechas/horas
    protected $casts = [
        'fecha_programada' => 'date',
        'hora_programada'  => 'datetime:H:i',
    ];

    // Relación con el usuario dueño de la programación
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
