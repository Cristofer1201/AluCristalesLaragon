<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Paso 1: ampliar el ENUM para incluir todos los valores (viejos + nuevos)
        DB::statement("ALTER TABLE presupuestos MODIFY COLUMN estado ENUM('borrador','enviado','aceptado','rechazado','vencido','terminado','generado','entregado') NOT NULL DEFAULT 'borrador'");

        // Paso 2: migrar datos viejos a nuevos valores
        DB::statement("UPDATE presupuestos SET estado = 'generado'  WHERE estado IN ('borrador', 'enviado')");
        DB::statement("UPDATE presupuestos SET estado = 'rechazado' WHERE estado = 'vencido'");
        DB::statement("UPDATE presupuestos SET estado = 'entregado' WHERE estado = 'terminado'");

        // Paso 3: dejar solo los nuevos valores en el ENUM
        DB::statement("ALTER TABLE presupuestos MODIFY COLUMN estado ENUM('generado','aceptado','rechazado','entregado') NOT NULL DEFAULT 'generado'");
    }

    public function down(): void
    {
        DB::statement("UPDATE presupuestos SET estado = 'borrador'  WHERE estado = 'generado'");
        DB::statement("UPDATE presupuestos SET estado = 'terminado' WHERE estado = 'entregado'");

        DB::statement("ALTER TABLE presupuestos MODIFY COLUMN estado ENUM('borrador','enviado','aceptado','rechazado','vencido','terminado') NOT NULL DEFAULT 'borrador'");
    }
};
