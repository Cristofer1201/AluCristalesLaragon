<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropUnique(['codigo']);
            $table->dropColumn('codigo');
            $table->unsignedInteger('orden')->default(0)->after('id');
        });

        // Asignar orden basado en el id actual
        DB::statement('UPDATE productos SET orden = id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('orden');
            $table->string('codigo', 10)->unique()->nullable()->after('id');
        });
    }
};
