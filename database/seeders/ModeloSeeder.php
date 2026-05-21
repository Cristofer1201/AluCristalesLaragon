<?php

namespace Database\Seeders;

use App\Helpers\GenerarCodigoHelper;
use App\Models\Modelos;
use App\Models\Productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        $data = [
            'Mamparas de Baños' => [
                'Mampara de Baño (Paño Fijo)',
                'Mampara de Baño (Rebatible)',
                'Mampara de Baño (Rebatible con bisagra cierre)',
                'Mampara de Baño (Box)',
                'Mampara de Baño (Frente Box)',
                'Mampara de Baño Fijo',
                'Mampara Frente Box Corredera',
                'Mampara Rebatible Dos Hojas',
                'Mampara Rebatible Paño Fijo',
                'Mampara de Baño Corredera',
                'Mampara de Baño Esquinero Box',
            ],
            'Vidrios' => [
                'N/A',
            ],
            'Cerramientos de Aluminio' => [
                'Modena',
                'Rotonda',
                'Herrero',
                'A-30',
                'A-40',
            ],
            'Cerramientos para Techos' => [
                'Techo Corredizo',
                'Techo Fijo',
                'Techo de aluminio con policarbonato',
                'Techo de aluminio con laminado',
                'Techo de vidrio',
            ],
            'Cerramientos para Ventanas' => [
                'Ventana Fija',
                'Ventana Oscilo Batiente',
                'Ventana Pivotante ',
                'Ventana Banderola',
                'Ventana Ventiluz',
                'Ventana Corrediza',
                'Ventana Rebatible',
                'Ventana Guiletina',

            ],
            'Puertas de Aluminio' => [
                'Puerta Postigon',
                'Puerta tabilla',
                'Puerta Templada',
                'Puerta mitad ciego y mitad vidrio',
                'Puerta vidrio completo',
                'Puerta con vidrio repartido',
                'Puerta Placard',
                'Puerta Granero',
            ],
            'Espejos' => [
                'Espejos con Luz Led',
                'Espejos con Formas',
                'Espejos Biselados',
            ],
            'Mosquiteros' => [
                'Mosquitero Fijo',
                'Mosquitero Corredizo',
            ],
            'Herrajes' => [
                'Herraje para Mampara',

            ],
            'N/A' => [
                'Otro',
            ],
        ];

        foreach ($data as $productoNombre => $modelos) {
            $producto = Productos::where('nombre', $productoNombre)->first();

            if (!$producto) continue;

            foreach ($modelos as $nombre) {
                $modelo = Modelos::firstOrCreate([
                    'nombre' => $nombre,
                    'producto_id' => $producto->id,
                    
                ], [
                    'activo' => 1
                ]);

                if (!$modelo->codigo) {
                    $modelo->codigo = GenerarCodigoHelper::generar('MOD', $modelo->id);
                    $modelo->save();
                }
            }

        }
    }
}