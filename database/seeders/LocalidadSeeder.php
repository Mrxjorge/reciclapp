<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalidadSeeder extends Seeder
{
    public function run(): void
    {
        $localidades = [
            'Usaquén','Chapinero','Santa Fe','San Cristóbal','Usme','Tunjuelito',
            'Bosa','Kennedy','Fontibón','Engativá','Suba','Barrios Unidos',
            'Teusaquillo','Los Mártires','Antonio Nariño','Puente Aranda',
            'La Candelaria','Rafael Uribe Uribe','Ciudad Bolívar','Sumapaz',
        ];

        foreach ($localidades as $nombre) {
            DB::table('localidades')->updateOrInsert(['nombre' => $nombre], ['nombre' => $nombre]);
        }
    }
}
