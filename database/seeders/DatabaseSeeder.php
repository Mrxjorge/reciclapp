<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Solo sembramos las localidades de Bogotá
        $this->call(LocalidadSeeder::class);

        // 2) NO creamos usuarios (ni de prueba ni aleatorios)
        //    Registrarás usuarios desde la UI de Breeze (/register)
    }
}
