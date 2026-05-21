<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
    use HasFactory;

    public function productos()
    {
        return $this->belongsToMany(
            Productos::class,
            'material_producto',
            'material_id',
            'producto_id'
        );
    }
}
