<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->unsignedTinyInteger('dia_organicos'); // 1=Lunes ... 7=Domingo
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('localidades');
    }
};
