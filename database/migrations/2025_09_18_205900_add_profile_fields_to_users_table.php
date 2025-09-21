<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo los campos que quieres conservar
            if (!Schema::hasColumn('users', 'cedula')) {
                $table->string('cedula')->unique();
            }
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono');
            }

            // IMPORTANTE: NO crear 'direccion' ni 'localidad_id'
            // y por supuesto NO agregar ninguna foreign key a 'localidades'
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'cedula')) {
                $table->dropColumn('cedula');
            }
            if (Schema::hasColumn('users', 'telefono')) {
                $table->dropColumn('telefono');
            }

            // No hay que soltar FKs de 'localidad_id' porque no las creamos.
        });
    }
};
