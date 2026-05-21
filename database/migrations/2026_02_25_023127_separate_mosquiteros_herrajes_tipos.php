<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('productos')
            ->whereIn('nombre', ['Mosquitero Fijo', 'Mosquitero Corredizo'])
            ->update(['tipo' => 'Mosquiteros']);

        DB::table('productos')
            ->where('nombre', 'Herraje para Mampara')
            ->update(['tipo' => 'Herrajes']);
    }

    public function down(): void
    {
        DB::table('productos')
            ->whereIn('nombre', ['Mosquitero Fijo', 'Mosquitero Corredizo', 'Herraje para Mampara'])
            ->update(['tipo' => 'Accesorios']);
    }
};
