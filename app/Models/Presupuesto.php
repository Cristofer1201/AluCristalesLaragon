<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'fecha',
        'cliente_id',
        'cliente_nombre',
        'cliente_direccion',
        'cliente_telefono',
        'cliente_email',
        'cliente_fax',
        'cliente_registro',
        'subtotal',
        'iva_porcentaje',
        'iva_monto',
        'total',
        'aplica_iva',
        'observacion',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'subtotal' => 'decimal:2',
        'iva_porcentaje' => 'decimal:2',
        'iva_monto' => 'decimal:2',
        'total' => 'decimal:2',
        'aplica_iva' => 'boolean',
    ];

    /**
     * Relacion con cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacion con usuario que creo el presupuesto
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacion con items del presupuesto
     */
    public function items()
    {
        return $this->hasMany(PresupuestoItem::class)->orderBy('orden');
    }

    /**
     * Generar el siguiente numero de presupuesto
     */
    public static function generarNumero()
    {
        $ultimoPresupuesto = self::orderBy('id', 'desc')->first();

        if ($ultimoPresupuesto) {
            $ultimoNumero = intval($ultimoPresupuesto->numero);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return str_pad($nuevoNumero, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Calcular totales del presupuesto
     */
    public function calcularTotales()
    {
        $subtotal = $this->items->sum('total');
        $this->subtotal = $subtotal;

        if ($this->aplica_iva) {
            $this->iva_monto = $subtotal * ($this->iva_porcentaje / 100);
            $this->total = $subtotal + $this->iva_monto;
        } else {
            $this->iva_monto = 0;
            $this->total = $subtotal;
        }

        $this->save();
    }
}
