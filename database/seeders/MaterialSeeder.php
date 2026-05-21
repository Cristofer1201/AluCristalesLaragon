<?php

namespace Database\Seeders;

use App\Helpers\GenerarCodigoHelper;
use App\Models\Materiales;
use App\Models\Productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Vidrios' => [
                'Vidrios',
                'Laminados',
                'Policarbonato',
                'Templado',
                'N/A',
            ],
            'Herrajes' => [
                'Burlete de Mampara',
                'Burletes Ventana',
                'Ruedas Doble Moderna',
                'Ruedas Doble Redonda',
                'Ruedas Doble Inferior',
                'Ruedas Simple Moderna',
                'Ruedas Simple Redonda',
                'Ruedas Simple Herraje',
                'Ruedas Reforzadas para Placa',
                'Ruedas para Puerta de Hierro o C',
                'Cocodrilo',
                'Grampas',
                'Manijas para ventanas',
                'Tapones herm',
                'Manija para puerta',
                'Manija Media Punto',
                'Brazo de Empuje Corto / Largo',
                'Chicotes',
                'Silicona Neutro',
                'Silicona Secado Rapido',
                'Dedales',
                'Topes para Mosquitero',
                'Kit para Mampara',
            ],
            '_default' => [
                'Liso',
                'Biselado',
                'Pulido',
                'Esmerilado',
                'Satinado',
            ],
        ];

        // 1️⃣ Crear todos los materiales
        $todosLosMateriales = collect($data)
            ->flatten()
            ->unique();

        $materialIds = [];

        foreach ($todosLosMateriales as $nombre) {
            $material = Materiales::firstOrCreate(
                ['nombre' => $nombre],
                ['activo' => 1]
            );

            if (!$material->codigo) {
                $material->codigo = GenerarCodigoHelper::generar('MAT', $material->id);
                $material->save();
            }

            $materialIds[$nombre] = $material->id;
        }

        // 2️⃣ Asociar materiales específicos
        $productosConConfig = [];

        foreach ($data as $productoNombre => $materiales) {
            if ($productoNombre === '_default') continue;

            $producto = Productos::where('nombre', $productoNombre)->first();
            if (!$producto) continue;

            $productosConConfig[] = $producto->id;

            foreach ($materiales as $nombreMaterial) {
                $producto->materiales()
                    ->syncWithoutDetaching($materialIds[$nombreMaterial]);
            }
        }

        // 3️⃣ Aplicar DEFAULT a productos restantes
        $materialesDefaultIds = collect($data['_default'])
            ->map(fn ($n) => $materialIds[$n])
            ->toArray();

        $productosDefault = Productos::whereNotIn('id', $productosConConfig)->get();

        foreach ($productosDefault as $producto) {
            $producto->materiales()
                ->syncWithoutDetaching($materialesDefaultIds);
        }
    }

}
