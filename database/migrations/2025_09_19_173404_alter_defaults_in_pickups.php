<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDefaultsInPickups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->string('modalidad')->default('programada')->change();
            $table->string('estado')->default('programada')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->string('modalidad')->nullable(false)->change();
            $table->string('estado')->nullable(false)->change();
        });
    }
}
