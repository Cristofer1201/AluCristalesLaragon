<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        return null;
    }

    public function materiales()
    {
        return $this->belongsToMany(
            Materiales::class,
            'material_producto',
            'producto_id',
            'material_id'
        );
    }

    public function colores(){
        return $this->belongsToMany(
            Colores::class,
            'producto_color',
            'producto_id',
            'color_id'
        );
    }
    
}
