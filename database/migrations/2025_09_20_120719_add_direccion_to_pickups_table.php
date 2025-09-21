<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            // agrega después de tipo_residuo para orden lógico
            $table->string('direccion')->after('tipo_residuo');
        });
    }

    public function down(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropColumn('direccion');
        });
    }
};
