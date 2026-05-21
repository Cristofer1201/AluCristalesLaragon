<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class GenerarCodigoHelper
{
    public static function generar(string $prefijo, int $ultimoId): string
    {
        return $prefijo . str_pad($ultimoId, 7, '0', STR_PAD_LEFT);
    }
}