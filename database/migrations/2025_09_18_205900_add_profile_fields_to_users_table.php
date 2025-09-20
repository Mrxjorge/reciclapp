<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cedula', 30)->unique()->after('email');
            $table->string('direccion')->after('cedula');
            $table->string('telefono', 30)->after('direccion');
            $table->foreignId('localidad_id')->nullable()->constrained('localidades')->nullOnDelete()->after('telefono');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('localidad_id');
            $table->dropColumn(['cedula','direccion','telefono']);
        });
    }
};
