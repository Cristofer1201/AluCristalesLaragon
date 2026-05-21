<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionEmpresa extends Model
{
    use HasFactory;

    protected $table = 'configuracion_empresa';

    protected $fillable = [
        'nombre',
        'cuit',
        'condicion_fiscal',
        'direccion',
        'direccion_alternativa',
        'telefono1',
        'telefono2',
        'email',
        'logo',
    ];

    /**
     * Obtener la configuracion de la empresa (singleton)
     */
    public static function obtener()
    {
        $config = self::first();

        if (!$config) {
            $config = self::create([
                'nombre' => 'ALU CRISTALES PALERMO',
                'cuit' => '27-96157559-7',
                'condicion_fiscal' => 'Responsable Inscripto',
                'direccion' => 'Araoz 2403 / Guemes 4888 / Palermo (CABA)',
                'telefono1' => '1135649430',
                'telefono2' => '1163219790',
                'email' => 'cristalespalermo2585@hotmail.com',
            ]);
        }

        return $config;
    }
}
