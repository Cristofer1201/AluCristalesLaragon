<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('tipo', 50)->nullable()->after('orden');
        });

        // Asignar tipos iniciales basados en los nombres existentes
        DB::table('productos')->where('nombre', 'like', 'Cerramientos%')->update(['tipo' => 'Cerramientos']);
        DB::table('productos')->where('nombre', 'Mamparas de Baños')->update(['tipo' => 'Mamparas']);
        DB::table('productos')->where('nombre', 'Vidrios')->update(['tipo' => 'Vidrios']);
        DB::table('productos')->where('nombre', 'Puertas de Aluminio')->update(['tipo' => 'Puertas']);
        DB::table('productos')->where('nombre', 'Espejos')->update(['tipo' => 'Espejos']);
        DB::table('productos')->where('nombre', 'Mosquiteros')->update(['tipo' => 'Accesorios']);
        DB::table('productos')->where('nombre', 'Herrajes')->update(['tipo' => 'Accesorios']);
        DB::table('productos')->where('nombre', 'N/A')->update(['tipo' => 'Otros']);
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
