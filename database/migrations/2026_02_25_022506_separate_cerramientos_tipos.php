<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cerramientos de Aluminio: perfiles/líneas de aluminio
        DB::table('productos')
            ->whereIn('nombre', ['Modena', 'Rotonda', 'Herrero', 'A-30', 'A-40'])
            ->update(['tipo' => 'Cerramientos de Aluminio']);

        // Cerramientos para Techos
        DB::table('productos')
            ->whereIn('nombre', [
                'Techo Corredizo',
                'Techo Fijo',
                'Techo de aluminio con policarbonato',
                'Techo de aluminio con laminado',
                'Techo de vidrio',
            ])
            ->update(['tipo' => 'Cerramientos para Techos']);

        // Cerramientos para Ventanas
        DB::table('productos')
            ->whereIn('nombre', [
                'Ventana Fija',
                'Ventana Oscilo Batiente',
                'Ventana Pivotante',
                'Ventana Banderola',
                'Ventana Ventiluz',
                'Ventana Corrediza',
                'Ventana Rebatible',
                'Ventana Guiletina',
            ])
            ->update(['tipo' => 'Cerramientos para Ventanas']);
    }

    public function down(): void
    {
        DB::table('productos')
            ->whereIn('nombre', [
                'Modena', 'Rotonda', 'Herrero', 'A-30', 'A-40',
                'Techo Corredizo', 'Techo Fijo', 'Techo de aluminio con policarbonato',
                'Techo de aluminio con laminado', 'Techo de vidrio',
                'Ventana Fija', 'Ventana Oscilo Batiente', 'Ventana Pivotante',
                'Ventana Banderola', 'Ventana Ventiluz', 'Ventana Corrediza',
                'Ventana Rebatible', 'Ventana Guiletina',
            ])
            ->update(['tipo' => 'Cerramientos']);
    }
};
