<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colores extends Model
{
    use HasFactory;

    public function productos(){
        return $this->belongsToMany(
            Productos::class,
            'producto_color',
            'producto_id',
            'color_id'
        );
    }
}
