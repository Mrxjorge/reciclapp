<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Clave foránea para 'users'
            $table->string('tipo_residuo'); // organico|inorganico|peligroso
            $table->string('subtipo')->nullable(); // fo|fv|poda (orgánicos)
            $table->string('modalidad')->default('programada'); // programada|demanda (inorgánico)
            $table->unsignedTinyInteger('frecuencia_semana')->nullable(); // 1|2 (inorgánico)
            $table->date('fecha_programada'); // Fecha de la recolección programada
            $table->time('hora_programada')->nullable(); // Hora programada de la recolección
            $table->decimal('kilos', 8, 2)->nullable(); // Kilos recolectados, lo llenará el recolector
            $table->unsignedInteger('turno')->nullable(); // Turno en la ruta de recolección
            $table->string('estado')->default('programada'); // Estado de la recolección: programada|completada|cancelada
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickups'); // Eliminar la tabla 'pickups'
    }
};
