<?php

namespace Database\Seeders;

use App\Helpers\GenerarCodigoHelper;
use App\Models\Colores;
use App\Models\Productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Vidrios' => [
                'Incoloro',
                'Cobre',
                'Gris',
                'Bronce',
                'Oro',
                'Negro',
                'Gris Diamante',
                'Blanco',
                'Satinado',
                'Anodizado Bronce Claro',
                'Anodizado Bronce Medio',
                'Anodizado Bronce Oscuro',
                'Anodizado Natural',
                'Anodizado Gris',
                'Anodizado Forte',
                'Anodizado Champagne',
                'Anodizado Negro',
            ],
            '_default' => [
                'Transparente',
                'Bronce',
                'Gris',
                'Azul',
                'Verde',
                'Negro',
                'Blanco',
            ],
        ];    


        // 1️⃣ Crear todos los colores
        $todosLosColores = collect($data)
            ->flatten()
            ->unique();

        $colorIds = [];

        foreach ($todosLosColores as $nombre) {
            $color = Colores::firstOrCreate(
                ['nombre' => $nombre],
                ['activo' => 1]
            );

            if (!$color->codigo) {
                $color->codigo = GenerarCodigoHelper::generar('COL', $color->id);
                $color->save();
            }

            $colorIds[$nombre] = $color->id;
        }

        // 2️⃣ Asociar colores específicos
        $productosConConfig = [];

        foreach ($data as $productoNombre => $colores) {
            if ($productoNombre === '_default') continue;

            $producto = Productos::where('nombre', $productoNombre)->first();
            if (!$producto) continue;

            $productosConConfig[] = $producto->id;

            foreach ($colores as $nombreColor) {
                $producto->colores()
                    ->syncWithoutDetaching($colorIds[$nombreColor]);
            }
        }

        // 3️⃣ Aplicar DEFAULT a productos restantes
        $coloresDefaultIds = collect($data['_default'])
            ->map(fn ($n) => $colorIds[$n])
            ->toArray();

        $productosDefault = Productos::whereNotIn('id', $productosConConfig)->get();

        foreach ($productosDefault as $producto) {
            $producto->colores()
                ->syncWithoutDetaching($coloresDefaultIds);
        }
    }
}
