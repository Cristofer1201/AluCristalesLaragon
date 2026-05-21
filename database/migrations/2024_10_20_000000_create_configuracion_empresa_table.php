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
        Schema::create('configuracion_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->default('ALU CRISTALES PALERMO');
            $table->string('cuit')->nullable();
            $table->string('condicion_fiscal')->default('Responsable Inscripto');
            $table->string('direccion')->nullable();
            $table->string('direccion_alternativa')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_empresa');
    }
};
