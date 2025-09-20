<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localidad;

class LocalidadSeeder extends Seeder
{
    /**
     * Mapea 1=Lunes ... 7=Domingo.
     * Este mapeo es de ejemplo; ajústalo a tu operación real.
     */
    private array $dias = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves',
        5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
    ];

    public function run(): void
    {
        // Lista oficial de localidades de Bogotá (20)
        // Mapeo "dummy" de día de orgánicos repartido equitativamente.
        $data = [
            ['nombre' => 'Usaquén',            'dia_organicos' => 1],
            ['nombre' => 'Chapinero',          'dia_organicos' => 2],
            ['nombre' => 'Santa Fe',           'dia_organicos' => 3],
            ['nombre' => 'San Cristóbal',      'dia_organicos' => 4],
            ['nombre' => 'Usme',               'dia_organicos' => 5],
            ['nombre' => 'Tunjuelito',         'dia_organicos' => 6],
            ['nombre' => 'Bosa',               'dia_organicos' => 7],
            ['nombre' => 'Kennedy',            'dia_organicos' => 1],
            ['nombre' => 'Fontibón',           'dia_organicos' => 2],
            ['nombre' => 'Engativá',           'dia_organicos' => 3],
            ['nombre' => 'Suba',               'dia_organicos' => 4],
            ['nombre' => 'Barrios Unidos',     'dia_organicos' => 5],
            ['nombre' => 'Teusaquillo',        'dia_organicos' => 6],
            ['nombre' => 'Los Mártires',       'dia_organicos' => 7],
            ['nombre' => 'Antonio Nariño',     'dia_organicos' => 1],
            ['nombre' => 'Puente Aranda',      'dia_organicos' => 2],
            ['nombre' => 'La Candelaria',      'dia_organicos' => 3],
            ['nombre' => 'Rafael Uribe Uribe', 'dia_organicos' => 4],
            ['nombre' => 'Ciudad Bolívar',     'dia_organicos' => 5],
            ['nombre' => 'Sumapaz',            'dia_organicos' => 6],
        ];

        foreach ($data as $row) {
            Localidad::firstOrCreate(['nombre' => $row['nombre']], $row);
        }
    }
}
