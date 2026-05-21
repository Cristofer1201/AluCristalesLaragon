<?php

namespace Database\Seeders;

use App\Models\Productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            // Mamparas (11)
            ['orden' => 1,  'nombre' => 'Mampara de Baño (Paño Fijo)',              'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 2,  'nombre' => 'Mampara de Baño (Rebatible)',              'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 3,  'nombre' => 'Mampara de Baño (Rebatible con bisagra cierre)', 'descripcion' => 'Mamparas de Baños',   'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 4,  'nombre' => 'Mampara de Baño (Box)',                    'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 5,  'nombre' => 'Mampara de Baño (Frente Box)',             'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 6,  'nombre' => 'Mampara de Baño Fijo',                     'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 7,  'nombre' => 'Mampara Frente Box Corredera',             'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 8,  'nombre' => 'Mampara Rebatible Dos Hojas',              'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 9,  'nombre' => 'Mampara Rebatible Paño Fijo',              'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 10, 'nombre' => 'Mampara de Baño Corredera',                'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],
            ['orden' => 11, 'nombre' => 'Mampara de Baño Esquinero Box',            'descripcion' => 'Mamparas de Baños',          'activo' => 1, 'tipo' => 'Mamparas'],

            // Cerramientos de Aluminio (5)
            ['orden' => 12, 'nombre' => 'Modena',   'descripcion' => 'Cerramientos de Aluminio', 'activo' => 1, 'tipo' => 'Cerramientos de Aluminio'],
            ['orden' => 13, 'nombre' => 'Rotonda',  'descripcion' => 'Cerramientos de Aluminio', 'activo' => 1, 'tipo' => 'Cerramientos de Aluminio'],
            ['orden' => 14, 'nombre' => 'Herrero',  'descripcion' => 'Cerramientos de Aluminio', 'activo' => 1, 'tipo' => 'Cerramientos de Aluminio'],
            ['orden' => 15, 'nombre' => 'A-30',     'descripcion' => 'Cerramientos de Aluminio', 'activo' => 1, 'tipo' => 'Cerramientos de Aluminio'],
            ['orden' => 16, 'nombre' => 'A-40',     'descripcion' => 'Cerramientos de Aluminio', 'activo' => 1, 'tipo' => 'Cerramientos de Aluminio'],

            // Cerramientos para Techos (5)
            ['orden' => 17, 'nombre' => 'Techo Corredizo',                    'descripcion' => 'Cerramientos para Techos', 'activo' => 1, 'tipo' => 'Cerramientos para Techos'],
            ['orden' => 18, 'nombre' => 'Techo Fijo',                         'descripcion' => 'Cerramientos para Techos', 'activo' => 1, 'tipo' => 'Cerramientos para Techos'],
            ['orden' => 19, 'nombre' => 'Techo de aluminio con policarbonato','descripcion' => 'Cerramientos para Techos', 'activo' => 1, 'tipo' => 'Cerramientos para Techos'],
            ['orden' => 20, 'nombre' => 'Techo de aluminio con laminado',     'descripcion' => 'Cerramientos para Techos', 'activo' => 1, 'tipo' => 'Cerramientos para Techos'],
            ['orden' => 21, 'nombre' => 'Techo de vidrio',                    'descripcion' => 'Cerramientos para Techos', 'activo' => 1, 'tipo' => 'Cerramientos para Techos'],

            // Cerramientos para Ventanas (8)
            ['orden' => 22, 'nombre' => 'Ventana Fija',           'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 23, 'nombre' => 'Ventana Oscilo Batiente','descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 24, 'nombre' => 'Ventana Pivotante',      'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 25, 'nombre' => 'Ventana Banderola',      'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 26, 'nombre' => 'Ventana Ventiluz',       'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 27, 'nombre' => 'Ventana Corrediza',      'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 28, 'nombre' => 'Ventana Rebatible',      'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],
            ['orden' => 29, 'nombre' => 'Ventana Guiletina',      'descripcion' => 'Cerramientos para Ventanas', 'activo' => 1, 'tipo' => 'Cerramientos para Ventanas'],

            // Puertas (8)
            ['orden' => 30, 'nombre' => 'Puerta Postigon',                    'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 31, 'nombre' => 'Puerta tabilla',                     'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 32, 'nombre' => 'Puerta Templada',                    'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 33, 'nombre' => 'Puerta mitad ciego y mitad vidrio',  'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 34, 'nombre' => 'Puerta vidrio completo',             'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 35, 'nombre' => 'Puerta con vidrio repartido',        'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 36, 'nombre' => 'Puerta Placard',                     'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],
            ['orden' => 37, 'nombre' => 'Puerta Granero',                     'descripcion' => 'Puertas de Aluminio', 'activo' => 1, 'tipo' => 'Puertas'],

            // Espejos (3)
            ['orden' => 38, 'nombre' => 'Espejos con Luz Led', 'descripcion' => 'Espejos', 'activo' => 1, 'tipo' => 'Espejos'],
            ['orden' => 39, 'nombre' => 'Espejos con Formas',  'descripcion' => 'Espejos', 'activo' => 1, 'tipo' => 'Espejos'],
            ['orden' => 40, 'nombre' => 'Espejos Biselados',   'descripcion' => 'Espejos', 'activo' => 1, 'tipo' => 'Espejos'],

            // Mosquiteros (2)
            ['orden' => 41, 'nombre' => 'Mosquitero Fijo',     'descripcion' => 'Mosquiteros', 'activo' => 1, 'tipo' => 'Mosquiteros'],
            ['orden' => 42, 'nombre' => 'Mosquitero Corredizo','descripcion' => 'Mosquiteros', 'activo' => 1, 'tipo' => 'Mosquiteros'],

            // Herrajes (1)
            ['orden' => 43, 'nombre' => 'Herraje para Mampara', 'descripcion' => 'Herrajes', 'activo' => 1, 'tipo' => 'Herrajes'],

            // Vidrios (1)
            ['orden' => 44, 'nombre' => 'Vidrios', 'descripcion' => 'Vidrios', 'activo' => 1, 'tipo' => 'Vidrios'],

            // Otros (1)
            ['orden' => 45, 'nombre' => 'Otro', 'descripcion' => 'N/A', 'activo' => 1, 'tipo' => 'Otros'],
        ];

        foreach ($productos as $data) {
            Productos::create($data);
        }
    }
}
