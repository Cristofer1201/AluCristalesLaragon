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
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique(); // Numero de presupuesto (ej: 00213)
            $table->date('fecha');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');

            // Datos del cliente (copia para mantener historial)
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_direccion')->nullable();
            $table->string('cliente_telefono')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_fax')->nullable();
            $table->string('cliente_registro')->nullable();

            // Totales
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('iva_porcentaje', 5, 2)->default(21);
            $table->decimal('iva_monto', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->boolean('aplica_iva')->default(true);

            // Observaciones
            $table->text('observacion')->nullable();

            // Estado
            $table->enum('estado', ['borrador', 'enviado', 'aceptado', 'rechazado', 'vencido'])->default('borrador');

            // Usuario que creo el presupuesto
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });

        // Tabla de items del presupuesto
        Schema::create('presupuesto_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained('presupuestos')->onDelete('cascade');
            $table->integer('orden')->default(1);

            // Datos del producto
            $table->string('tipo_producto')->nullable();
            $table->string('modelo')->nullable();
            $table->string('color_aluminio')->nullable();
            $table->string('tipo_vidrio')->nullable();
            $table->string('espesor_vidrio')->nullable();
            $table->string('tipo_apertura')->nullable();

            // Dimensiones
            $table->decimal('ancho', 10, 2)->nullable();
            $table->decimal('alto', 10, 2)->nullable();
            $table->decimal('area', 10, 4)->nullable();

            // Especificaciones adicionales
            $table->string('premarco')->nullable();
            $table->string('tapajuntas')->nullable();
            $table->string('angulo')->nullable();
            $table->string('linea')->nullable();

            // Descripcion completa generada
            $table->text('descripcion')->nullable();

            // Precios
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 12, 2)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuesto_items');
        Schema::dropIfExists('presupuestos');
    }
};
