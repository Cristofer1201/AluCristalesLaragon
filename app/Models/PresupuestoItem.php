<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'presupuesto_id',
        'orden',
        'tipo_producto',
        'modelo',
        'color_aluminio',
        'tipo_vidrio',
        'espesor_vidrio',
        'tipo_apertura',
        'ancho',
        'alto',
        'area',
        'premarco',
        'tapajuntas',
        'angulo',
        'linea',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento_porcentaje',
        'descuento_monto',
        'total',
    ];

    protected $casts = [
        'ancho' => 'decimal:2',
        'alto' => 'decimal:2',
        'area' => 'decimal:4',
        'precio_unitario' => 'decimal:2',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Relacion con presupuesto
     */
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }

    /**
     * Generar descripcion automatica del item
     */
    public function generarDescripcion()
    {
        $partes = [];

        if ($this->tipo_producto) {
            $partes[] = ucfirst(str_replace('_', ' ', $this->tipo_producto));
        }
        if ($this->modelo) {
            $partes[] = $this->modelo;
        }
        if ($this->color_aluminio) {
            $partes[] = "Color: " . $this->color_aluminio;
        }
        if ($this->tipo_vidrio) {
            $partes[] = "Vidrio: " . $this->tipo_vidrio;
        }
        if ($this->ancho && $this->alto) {
            $partes[] = $this->ancho . "x" . $this->alto . " cm";
        }

        $this->descripcion = implode(' - ', $partes);
        return $this->descripcion;
    }

    /**
     * Calcular total del item
     */
    public function calcularTotal()
    {
        $subtotal = $this->cantidad * $this->precio_unitario * ($this->area ?? 1);
        $this->descuento_monto = $subtotal * ($this->descuento_porcentaje / 100);
        $this->total = $subtotal - $this->descuento_monto;
        return $this->total;
    }
}
