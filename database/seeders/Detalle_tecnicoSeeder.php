<?php

namespace Database\Seeders;

use App\Helpers\GenerarCodigoHelper;
use App\Models\Detalles_tecnicos;
use App\Models\Materiales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Detalle_tecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            'Vidrios' => [
                'Vidrio de 4 mm',
                'Vidrio de 5 mm',
                'Vidrio de 6 mm',
                'Vidrio pulido',
                'Vidrio mate',
                'Vidrio laminado',
                'Vidrio monolítico',
                'Vidrio ahumado',
            ],
            'Laminados' => [
                'Laminado 3+3',
                'Laminado Opalino 3+3',
                'Laminado 4+4',
                'Laminado 5+5',
            ],
            'Policarbonato' => [
                'Policarbonato 8mm',
            ],
            'Templado' => [
                'Templado 8mm',
                'Templado 10mm',
            ],
            'N/A' => [
                'N/A',
            ],
            // Herrajes - todos con N/A en detalle
            'Burlete de Mampara' => [
                'N/A',
            ],
            'Burletes Ventana' => [
                'N/A',
            ],
            'Ruedas Doble Moderna' => [
                'N/A',
            ],
            'Ruedas Doble Redonda' => [
                'N/A',
            ],
            'Ruedas Doble Inferior' => [
                'N/A',
            ],
            'Ruedas Simple Moderna' => [
                'N/A',
            ],
            'Ruedas Simple Redonda' => [
                'N/A',
            ],
            'Ruedas Simple Herraje' => [
                'N/A',
            ],
            'Ruedas Reforzadas para Placa' => [
                'N/A',
            ],
            'Ruedas para Puerta de Hierro o C' => [
                'N/A',
            ],
            'Cocodrilo' => [
                'N/A',
            ],
            'Grampas' => [
                'N/A',
            ],
            'Manijas para ventanas' => [
                'N/A',
            ],
            'Tapones herm' => [
                'N/A',
            ],
            'Manija para puerta' => [
                'N/A',
            ],
            'Manija media punto' => [
                'N/A',
            ],
            'Brazo de Empuje Corto / Largo' => [
                'N/A',
            ],
            'Chicotes' => [
                'N/A',
            ],
            'Silicona Neutro' => [
                'N/A',
            ],
            'Silicona Secado Rapido' => [
                'N/A',
            ],
            'Dedales' => [
                'N/A',
            ],
            'Topes para Mosquitero' => [
                'N/A',
            ],
            'Kit para Mampara' => [
                'N/A',
            ],
            '_default' => [
                'Sin detalle',
                'Borde pulido',
                'Con perforaciones',
                'Cantos biselados',
                'Esquinas redondeadas',
            ],
        ];

        $defaultDetalles = $data['_default'];
        unset($data['_default']);

        foreach ($data as $materialNombre => $detalles) {
            $material = Materiales::where('nombre', $materialNombre)->first();
            if (!$material) continue;

            foreach ($detalles as $nombre) {
                $detalle = Detalles_tecnicos::firstOrCreate([
                    'nombre' => $nombre,
                    'material_id' => $material->id
                ], [
                    'activo' => 1
                ]);

                if (!$detalle->codigo) {
                    $detalle->codigo = GenerarCodigoHelper::generar('DET', $detalle->id);
                    $detalle->save();
                }
            }
        }

        $materialesConDetallesEspecificos = array_keys($data);

        $materialesDefault = Materiales::whereNotIn('nombre', $materialesConDetallesEspecificos)->get();

        foreach ($materialesDefault as $material) {
            foreach ($defaultDetalles as $nombre) {
                $detalle = Detalles_tecnicos::firstOrCreate([
                    'nombre' => $nombre,
                    'material_id' => $material->id
                ], [
                    'activo' => 1
                ]);

                if (!$detalle->codigo) {
                    $detalle->codigo = GenerarCodigoHelper::generar('DET', $detalle->id);
                    $detalle->save();
                }
            }
        }

    }
}
