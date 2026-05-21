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
        Schema::create('detalles_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',15)->unique()->nullable(true);
            $table->string('nombre', 50);
            $table->boolean('activo')->default(true);
            $table->foreignId('material_id')
                ->nullable()
                ->references('id')
                ->on('materiales')

                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_tecnicos');
    }
};
