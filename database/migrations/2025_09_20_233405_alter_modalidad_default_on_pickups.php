<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Rellena por si quedó algún NULL o cadena vacía
        DB::statement("UPDATE pickups SET modalidad='programada' WHERE modalidad IS NULL OR modalidad=''");

        // Establece NOT NULL + DEFAULT 'programada'
        // (MySQL/MariaDB)
        DB::statement("ALTER TABLE pickups MODIFY modalidad VARCHAR(20) NOT NULL DEFAULT 'programada'");
    }

    public function down(): void
    {
        // Reversión: quita el DEFAULT, mantiene NOT NULL
        DB::statement("ALTER TABLE pickups MODIFY modalidad VARCHAR(20) NOT NULL");
    }
};
