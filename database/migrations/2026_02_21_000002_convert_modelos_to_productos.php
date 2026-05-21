<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mapeo: producto padre => tipo, con sus sub-productos (modelos)
        $data = [
            'Mamparas de Baños' => [
                'tipo' => 'Mamparas',
                'modelos' => [
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
            ],
            'Cerramientos de Aluminio' => [
                'tipo' => 'Cerramientos',
                'modelos' => ['Modena', 'Rotonda', 'Herrero', 'A-30', 'A-40'],
            ],
            'Cerramientos para Techos' => [
                'tipo' => 'Cerramientos',
                'modelos' => [
                    'Techo Corredizo',
                    'Techo Fijo',
                    'Techo de aluminio con policarbonato',
                    'Techo de aluminio con laminado',
                    'Techo de vidrio',
                ],
            ],
            'Cerramientos para Ventanas' => [
                'tipo' => 'Cerramientos',
                'modelos' => [
                    'Ventana Fija',
                    'Ventana Oscilo Batiente',
                    'Ventana Pivotante',
                    'Ventana Banderola',
                    'Ventana Ventiluz',
                    'Ventana Corrediza',
                    'Ventana Rebatible',
                    'Ventana Guiletina',
                ],
            ],
            'Puertas de Aluminio' => [
                'tipo' => 'Puertas',
                'modelos' => [
                    'Puerta Postigon',
                    'Puerta tabilla',
                    'Puerta Templada',
                    'Puerta mitad ciego y mitad vidrio',
                    'Puerta vidrio completo',
                    'Puerta con vidrio repartido',
                    'Puerta Placard',
                    'Puerta Granero',
                ],
            ],
            'Espejos' => [
                'tipo' => 'Espejos',
                'modelos' => [
                    'Espejos con Luz Led',
                    'Espejos con Formas',
                    'Espejos Biselados',
                ],
            ],
            'Mosquiteros' => [
                'tipo' => 'Accesorios',
                'modelos' => ['Mosquitero Fijo', 'Mosquitero Corredizo'],
            ],
            'Herrajes' => [
                'tipo' => 'Accesorios',
                'modelos' => ['Herraje para Mampara'],
            ],
            'Vidrios' => [
                'tipo' => 'Vidrios',
                'modelos' => [],
            ],
            'N/A' => [
                'tipo' => 'Otros',
                'modelos' => ['Otro'],
            ],
        ];

        // Deshabilitar foreign keys para poder truncar
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Limpiar tablas pivote y modelos relacionados
        DB::table('material_producto')->truncate();
        DB::table('producto_color')->truncate();
        DB::table('modelos')->truncate();

        // Eliminar todos los productos actuales (son categorias padre)
        DB::table('productos')->truncate();

        // Rehabilitar foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $orden = 1;

        foreach ($data as $padreNombre => $info) {
            $tipo = $info['tipo'];
            $modelos = $info['modelos'];

            if (empty($modelos)) {
                // Si no hay modelos, mantener el producto padre como producto
                DB::table('productos')->insert([
                    'nombre' => $padreNombre,
                    'descripcion' => $padreNombre,
                    'tipo' => $tipo,
                    'activo' => 1,
                    'orden' => $orden++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                foreach ($modelos as $modelo) {
                    DB::table('productos')->insert([
                        'nombre' => $modelo,
                        'descripcion' => $padreNombre,
                        'tipo' => $tipo,
                        'activo' => 1,
                        'orden' => $orden++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        // Restaurar los 10 productos originales
        DB::table('productos')->truncate();

        $productos = [
            ['orden' => 1, 'nombre' => 'Mamparas de Baños', 'descripcion' => 'Mamparas de baño', 'tipo' => 'Mamparas', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 2, 'nombre' => 'Vidrios', 'descripcion' => 'Vidrios', 'tipo' => 'Vidrios', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 3, 'nombre' => 'Cerramientos de Aluminio', 'descripcion' => 'Cerramientos de aluminio', 'tipo' => 'Cerramientos', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 4, 'nombre' => 'Cerramientos para Techos', 'descripcion' => 'Cerramientos para techos', 'tipo' => 'Cerramientos', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 5, 'nombre' => 'Cerramientos para Ventanas', 'descripcion' => 'Cerramientos para ventanas', 'tipo' => 'Cerramientos', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 6, 'nombre' => 'Puertas de Aluminio', 'descripcion' => 'Puertas de aluminio', 'tipo' => 'Puertas', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 7, 'nombre' => 'Espejos', 'descripcion' => 'Espejos', 'tipo' => 'Espejos', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 8, 'nombre' => 'Mosquiteros', 'descripcion' => 'Mosquiteros', 'tipo' => 'Accesorios', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 9, 'nombre' => 'Herrajes', 'descripcion' => 'Herrajes', 'tipo' => 'Accesorios', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['orden' => 10, 'nombre' => 'N/A', 'descripcion' => 'N/A', 'tipo' => 'Otros', 'activo' => 1, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('productos')->insert($productos);
    }
};
