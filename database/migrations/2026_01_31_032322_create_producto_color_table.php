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
        Schema::create('producto_color', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('color_id')
                ->constrained('colores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unique(['producto_id', 'color_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_color');
    }
};
