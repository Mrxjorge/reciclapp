<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            // nullable por si ya hay registros; si quieres forzar siempre, luego podrás cambiar a notNullable
            $table->foreignId('localidad_id')
                  ->nullable()
                  ->constrained('localidades')
                  ->nullOnDelete(); // si borran la localidad, queda null
        });
    }

    public function down(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropForeign(['localidad_id']);
            $table->dropColumn('localidad_id');
        });
    }
};
