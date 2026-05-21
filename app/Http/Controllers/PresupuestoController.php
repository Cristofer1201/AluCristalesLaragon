<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\PresupuestoItem;
use App\Models\ConfiguracionEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PresupuestoController extends Controller
{
    /**
     * Mostrar la vista de presupuesto
     */
    public function index()
    {
        // Datos fijos para los dropdowns
        $tipos = [
            'mamparas_baños' => 'Mamparas de Baños',
            'vidrios' => 'Vidrios',
            'cerramientos_aluminio' => 'Cerramientos de Aluminio',
            'cerramientos_techos' => 'Cerramientos para Techos',
            'cerramientos_ventanas' => 'Cerramientos para Ventanas',
            'puertas_aluminio' => 'Puertas de Aluminio',
            'espejos' => 'Espejos',
            'mosquiteros' => 'Mosquiteros',
            'herrajes' => 'Herrajes',
            'na' => 'N/A',
        ];

        // Opciones dinámicas por tipo de producto
        $opcionesPorTipo = [
            'mamparas_baños' => [
                'mampara_pano_fijo' => 'Mampara de Baño (Paño Fijo)',
                'mampara_rebatible' => 'Mampara de Baño (Rebatible)',
                'mampara_rebatible_bisagra' => 'Mampara de Baño (Rebatible con bisagra cierre)',
                'mampara_box' => 'Mampara de Baño (Box)',
                'mampara_frente_box' => 'Mampara de Baño (Frente Box)',
                'mampara_fijo' => 'Mampara de Baño Fijo',
                'mampara_frente_corredera' => 'Mampara Frente Box Corredera',
                'mampara_rebatible_dos_hojas' => 'Mampara Rebatible Dos Hojas',
                'mampara_rebatible_pano_fijo' => 'Mampara Rebatible Paño Fijo',
                'mampara_corredera' => 'Mampara de Baño Corredera',
                'mampara_esquinero_box' => 'Mampara de Baño Esquinero Box',
            ],
            'vidrios' => [
                'na' => 'N/A',
            ],
            'cerramientos_aluminio' => [
                'modena' => 'Modena',
                'rotonda' => 'Rotonda',
                'herrero' => 'Herrero',
                'a-30' => 'A-30',
                'a-40' => 'A-40',
            ],
            'cerramientos_techos' => [
                'techo_corredizo' => 'Techo Corredizo',
                'techo_fijo' => 'Techo Fijo',
                'techo_aluminio_policarbonato' => 'Techo de aluminio con policarbonato',
                'techo_aluminio_laminado' => 'Techo de aluminio con laminado',
                'techo_vidrio' => 'Techo de vidrio',
            ],
            'cerramientos_ventanas' => [
                'ventana_fija' => 'Ventana Fija',
                'ventana_oscilo_batiente' => 'Ventana Oscilo Batiente',
                'ventana_pivotante' => 'Ventana Pivotante ',
                'ventana_banderola' => 'Ventana Banderola',
                'ventana_ventiluz' => 'Ventana Ventiluz',
                'ventana_corrediza' => 'Ventana Corrediza',
                'ventana_rebatible' => 'Ventana Rebatible',
                'ventana_guiletina' => 'Ventana Guiletina',

            ],
            'puertas_aluminio' => [
                'puerta_postigon' => 'Puerta Postigon',
                'puerta_tabilla' => 'Puerta tabilla',
                'puerta_templada' => 'Puerta Templada',
                'puerta_mitad_ciego_mitad_vidrio' => 'Puerta mitad ciego y mitad vidrio',
                'puerta_vidrio_completo' => 'Puerta vidrio completo',
                'puerta_vidrio_repartido' => 'Puerta con vidrio repartido',
                'puerta_placard' => 'Puerta Placard',
                'puerta_granero' => 'Puerta Granero',
            ],
            'espejos' => [
                'espejo_luz_led' => 'Espejos con Luz Led',
                'espejo_formas' => 'Espejos con Formas',
                'espejo_biselados' => 'Espejos Biselados',
            ],
            'mosquiteros' => [
                'mosquitero_fijo' => 'Mosquitero Fijo',
                'mosquitero_corredizo' => 'Mosquitero Corredizo',
            ],
            'herrajes' => [
                'herraje_mampara' => 'Herraje para Mampara',

            ],
            'na' => [
                'otro' => 'Otro',
            ],
        ];

        $opciones = [
            'estandar' => 'Estandar',
            'premium' => 'Premium',
            'economico' => 'Economico',
        ];

        // Colores dinámicos por tipo de producto
        $coloresPorTipo = [
            'vidrios' => [
                'incoloro' => 'Incoloro',
                'cobre' => 'Cobre',
                'gris' => 'Gris',
                'bronce' => 'Bronce',
                'oro' => 'Oro',
                'negro' => 'Negro',
                'gris_diamante' => 'Gris Diamante',
                'blanco' => 'Blanco',
                'satinado' => 'Satinado',
                'anodizado_bronce_claro' => 'Anodizado Bronce Claro',
                'anodizado_bronce_medio' => 'Anodizado Bronce Medio',
                'anodizado_bronce_oscuro' => 'Anodizado Bronce Oscuro',
                'anodizado_natural' => 'Anodizado Natural',
                'anodizado_gris' => 'Anodizado Gris',
                'anodizado_forte' => 'Anodizado Forte',
                'anodizado_champagne' => 'Anodizado Champagne',
                'anodizado_negro' => 'Anodizado Negro',
            ],
            '_default' => [
                'transparente' => 'Transparente',
                'bronce' => 'Bronce',
                'gris' => 'Gris',
                'azul' => 'Azul',
                'verde' => 'Verde',
                'negro' => 'Negro',
                'blanco' => 'Blanco',
            ],
        ];

        $colores = [
            'transparente' => 'Transparente',
            'bronce' => 'Bronce',
            'gris' => 'Gris',
            'azul' => 'Azul',
            'verde' => 'Verde',
            'negro' => 'Negro',
            'blanco' => 'Blanco',
        ];

        // Tipos de detalle dinámicos por tipo de producto
        $tiposDetallePorTipo = [
            'vidrios' => [
                'vidrios' => 'Vidrios',
                'laminados' => 'Laminados',
                'policarbonato' => 'Policarbonato',
                'templado' => 'Templado',
                'na' => 'N/A',
            ],
            'herrajes' => [
                'burlete_mampara' => 'Burlete de Mampara',
                'burletes_ventana' => 'Burletes Ventana',
                'ruedas_doble_moderna' => 'Ruedas Doble Moderna',
                'ruedas_doble_redonda' => 'Ruedas Doble Redonda',
                'ruedas_doble_inferior' => 'Ruedas Doble Inferior',
                'ruedas_simple_moderna' => 'Ruedas Simple Moderna',
                'ruedas_simple_redonda' => 'Ruedas Simple Redonda',
                'ruedas_simple_herraje' => 'Ruedas Simple Herraje',
                'ruedas_reforzadas_placa' => 'Ruedas Reforzadas para Placa',
                'ruedas_puerta_hierro' => 'Ruedas para Puerta de Hierro o C',
                'cocodrilo' => 'Cocodrilo',
                'grampas' => 'Grampas',
                'manijas_ventanas' => 'Manijas para ventanas',
                'tapones_herm' => 'Tapones herm',
                'manija_puerta' => 'Manija para puerta',
                'manija_media_punto' => 'Manija Media Punto',
                'brazo_empuje' => 'Brazo de Empuje Corto / Largo',
                'chicotes' => 'Chicotes',
                'silicona_neutro' => 'Silicona Neutro',
                'silicona_secado_rapido' => 'Silicona Secado Rapido',
                'dedales' => 'Dedales',
                'topes_mosquitero' => 'Topes para Mosquitero',
                'kit_mampara' => 'Kit para Mampara',
            ],
            '_default' => [
                'liso' => 'Liso',
                'biselado' => 'Biselado',
                'pulido' => 'Pulido',
                'esmerilado' => 'Esmerilado',
                'satinado' => 'Satinado',
            ],
        ];

        $tiposDetalle = [
            'liso' => 'Liso',
            'biselado' => 'Biselado',
            'pulido' => 'Pulido',
            'esmerilado' => 'Esmerilado',
            'satinado' => 'Satinado',
        ];

        // Detalles dinámicos por tipo de detalle
        $detallesPorTipoDetalle = [
            'vidrios' => [
                'vidrio_4mm' => 'Vidrio de 4 mm',
                'vidrio_5mm' => 'Vidrio de 5 mm',
                'vidrio_6mm' => 'Vidrio de 6 mm',
                'vidrio_pulido' => 'Vidrio pulido',
                'vidrio_mate' => 'Vidrio mate',
                'vidrio_laminado' => 'Vidrio laminado',
                'vidrio_monolitico' => 'Vidrio monolítico',
                'vidrio_ahumado' => 'Vidrio ahumado',
            ],
            'laminados' => [
                'laminado_3_3' => 'Laminado 3+3',
                'laminado_opalino_3_3' => 'Laminado Opalino 3+3',
                'laminado_4_4' => 'Laminado 4+4',
                'laminado_5_5' => 'Laminado 5+5',
            ],
            'policarbonato' => [
                'policarbonato_8mm' => 'Policarbonato 8mm',
            ],
            'templado' => [
                'templado_8mm' => 'Templado 8mm',
                'templado_10mm' => 'Templado 10mm',
            ],
            'na' => [
                'n/a' => 'N/A',
            ],
            // Herrajes - todos con N/A en detalle
            'burlete_mampara' => [
                'n/a' => 'N/A',
            ],
            'burletes_ventana' => [
                'n/a' => 'N/A',
            ],
            'ruedas_doble_moderna' => [
                'n/a' => 'N/A',
            ],
            'ruedas_doble_redonda' => [
                'n/a' => 'N/A',
            ],
            'ruedas_doble_inferior' => [
                'n/a' => 'N/A',
            ],
            'ruedas_simple_moderna' => [
                'n/a' => 'N/A',
            ],
            'ruedas_simple_redonda' => [
                'n/a' => 'N/A',
            ],
            'ruedas_simple_herraje' => [
                'n/a' => 'N/A',
            ],
            'ruedas_reforzadas_placa' => [
                'n/a' => 'N/A',
            ],
            'ruedas_puerta_hierro' => [
                'n/a' => 'N/A',
            ],
            'cocodrilo' => [
                'n/a' => 'N/A',
            ],
            'grampas' => [
                'n/a' => 'N/A',
            ],
            'manijas_ventanas' => [
                'n/a' => 'N/A',
            ],
            'tapones_herm' => [
                'n/a' => 'N/A',
            ],
            'manija_puerta' => [
                'n/a' => 'N/A',
            ],
            'manija_media_punto' => [
                'n/a' => 'N/A',
            ],
            'brazo_empuje' => [
                'n/a' => 'N/A',
            ],
            'chicotes' => [
                'n/a' => 'N/A',
            ],
            'silicona_neutro' => [
                'n/a' => 'N/A',
            ],
            'silicona_secado_rapido' => [
                'n/a' => 'N/A',
            ],
            'dedales' => [
                'n/a' => 'N/A',
            ],
            'topes_mosquitero' => [
                'n/a' => 'N/A',
            ],
            'kit_mampara' => [
                'n/a' => 'N/A',
            ],
            '_default' => [
                'sin_detalle' => 'Sin detalle',
                'borde_pulido' => 'Borde pulido',
                'perforaciones' => 'Con perforaciones',
                'cantos_biselados' => 'Cantos biselados',
                'esquinas_redondeadas' => 'Esquinas redondeadas',
            ],
        ];

        $detalles = [
            'sin_detalle' => 'Sin detalle',
            'borde_pulido' => 'Borde pulido',
            'perforaciones' => 'Con perforaciones',
            'cantos_biselados' => 'Cantos biselados',
            'esquinas_redondeadas' => 'Esquinas redondeadas',
        ];

        $espesores = [
            '3' => '3 mm',
            '4' => '4 mm',
            '5' => '5 mm',
            '6' => '6 mm',
            '8' => '8 mm',
            '10' => '10 mm',
            '12' => '12 mm',
        ];

        // === ESPECIFICACIONES ===

        // Premarco - Sí/No para todos
        $premarcoPorTipo = [
            '_default' => [
                'si' => 'Sí',
                'no' => 'No',
            ],
        ];

        // Línea dinámico por tipo de producto
        $lineaPorTipo = [
            'cerramientos_aluminio' => [
                'modena' => 'Modena',
                'rotonda' => 'Rotonda',
                'herrero' => 'Herrero',
                'a-30' => 'A-30',
                'a-40' => 'A-40',
            ],
            'cerramientos_ventanas' => [
                'modena' => 'Modena',
                'rotonda' => 'Rotonda',
                'herrero' => 'Herrero',
                'a-30' => 'A-30',
                'a-40' => 'A-40',
            ],
            'puertas_aluminio' => [
                'modena' => 'Modena',
                'rotonda' => 'Rotonda',
                'herrero' => 'Herrero',
                'a-30' => 'A-30',
                'a-40' => 'A-40',
            ],
            '_default' => [
                'na' => 'N/A',
            ],
        ];

        // Tapajuntas - Sí/No para todos
        $tapajuntasPorTipo = [
            '_default' => [
                'si' => 'Sí',
                'no' => 'No',
            ],
        ];

        // Ángulo - Sí/No para todos
        $anguloPorTipo = [
            '_default' => [
                'si' => 'Sí',
                'no' => 'No',
            ],
        ];

        $presupuestoEditar = null;
        if ($editarId = request('editar')) {
            $presupuestoEditar = Presupuesto::with('items')->find($editarId);
        }

        return view('presupuesto.index', compact(
            'tipos',
            'opciones',
            'opcionesPorTipo',
            'colores',
            'coloresPorTipo',
            'tiposDetalle',
            'tiposDetallePorTipo',
            'detalles',
            'detallesPorTipoDetalle',
            'espesores',
            'premarcoPorTipo',
            'lineaPorTipo',
            'tapajuntasPorTipo',
            'anguloPorTipo',
            'presupuestoEditar'
        ));
    }

    /**
     * Actualizar presupuesto existente (modo edicion)
     */
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $presupuesto = Presupuesto::findOrFail($id);

            $subtotal = collect($request->items)->sum('total');
            $aplicaIva = $request->aplica_iva ?? false;
            $ivaMonto = $aplicaIva ? $subtotal * 0.21 : 0;
            $total = $subtotal + $ivaMonto;

            $presupuesto->update([
                'cliente_id'        => $request->cliente_id,
                'cliente_nombre'    => $request->cliente_nombre,
                'cliente_direccion' => $request->cliente_direccion,
                'cliente_telefono'  => $request->cliente_telefono,
                'cliente_email'     => $request->cliente_email,
                'cliente_fax'       => $request->cliente_fax,
                'subtotal'          => $subtotal,
                'iva_monto'         => $ivaMonto,
                'total'             => $total,
                'aplica_iva'        => $aplicaIva,
                'observacion'       => $request->observacion,
            ]);

            $presupuesto->items()->delete();

            foreach ($request->items as $index => $itemData) {
                $ancho = floatval($itemData['ancho'] ?? 0);
                $alto  = floatval($itemData['alto'] ?? 0);
                PresupuestoItem::create([
                    'presupuesto_id'       => $presupuesto->id,
                    'orden'                => $index + 1,
                    'tipo_producto'        => $itemData['tipo_producto'] ?? null,
                    'modelo'               => $itemData['modelo'] ?? null,
                    'color_aluminio'       => $itemData['color_aluminio'] ?? null,
                    'ancho'                => $ancho ?: null,
                    'alto'                 => $alto ?: null,
                    'area'                 => ($ancho > 0 && $alto > 0) ? round($ancho * $alto / 10000, 4) : null,
                    'cantidad'             => $itemData['cantidad'] ?? 1,
                    'precio_unitario'      => $itemData['precio_unitario'] ?? 0,
                    'descuento_porcentaje' => $itemData['descuento_porcentaje'] ?? 0,
                    'total'                => $itemData['total'] ?? 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'presupuesto'  => $presupuesto->load('items'),
                'message'      => 'Presupuesto actualizado correctamente',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener el siguiente numero de presupuesto
     */
    public function siguienteNumero()
    {
        $numero = Presupuesto::generarNumero();
        return response()->json(['numero' => $numero]);
    }

    /**
     * Guardar presupuesto con sus items
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'numero' => 'required|string',
            'fecha' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Calcular subtotal
            $subtotal = collect($request->items)->sum('total');
            $aplicaIva = $request->aplica_iva ?? true;
            $ivaPorcentaje = 21;
            $ivaMonto = $aplicaIva ? $subtotal * ($ivaPorcentaje / 100) : 0;
            $total = $subtotal + $ivaMonto;

            // Crear presupuesto
            $presupuesto = Presupuesto::create([
                'numero' => $request->numero,
                'fecha' => $request->fecha,
                'cliente_id' => $request->cliente_id,
                'cliente_nombre' => $request->cliente_nombre,
                'cliente_direccion' => $request->cliente_direccion,
                'cliente_telefono' => $request->cliente_telefono,
                'cliente_email' => $request->cliente_email,
                'cliente_fax' => $request->cliente_fax,
                'cliente_registro' => $request->cliente_registro,
                'subtotal' => $subtotal,
                'iva_porcentaje' => $ivaPorcentaje,
                'iva_monto' => $ivaMonto,
                'total' => $total,
                'aplica_iva' => $aplicaIva,
                'observacion' => $request->observacion,
                'estado' => 'generado',
                'user_id' => Auth::id(),
            ]);

            // Crear items
            foreach ($request->items as $index => $itemData) {
                PresupuestoItem::create([
                    'presupuesto_id' => $presupuesto->id,
                    'orden' => $index + 1,
                    'tipo_producto' => $itemData['tipo_producto'] ?? null,
                    'modelo' => $itemData['modelo'] ?? null,
                    'color_aluminio' => $itemData['color_aluminio'] ?? null,
                    'ancho' => $itemData['ancho'] ?? null,
                    'alto' => $itemData['alto'] ?? null,
                    'area' => $itemData['area'] ?? null,
                    'cantidad' => $itemData['cantidad'] ?? 1,
                    'precio_unitario' => $itemData['precio_unitario'] ?? 0,
                    'descuento_porcentaje' => $itemData['descuento_porcentaje'] ?? 0,
                    'total' => $itemData['total'] ?? 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'presupuesto' => $presupuesto->load('items'),
                'message' => 'Presupuesto guardado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener configuracion de la empresa
     */
    public function configuracionEmpresa()
    {
        $config = ConfiguracionEmpresa::obtener();
        return response()->json($config);
    }

    /**
     * Obtener mapa de imagenes de productos
     */
    private function getProductoImagenes($subdirectory = null)
    {
        $productoImagenes = [];
        $relativePath = $subdirectory ? 'img/productos/' . $subdirectory : 'img/productos';
        $imageDir = public_path($relativePath);
        if (is_dir($imageDir)) {
            $files = scandir($imageDir);
            foreach ($files as $file) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp'])) {
                    $name = pathinfo($file, PATHINFO_FILENAME);
                    $productoImagenes[mb_strtolower($name)] = $relativePath . '/' . $file;
                }
            }
        }
        return $productoImagenes;
    }

    /**
     * Mostrar vista previa del PDF
     */
    public function mostrarPDF($id)
    {
        $presupuesto = Presupuesto::with('items')->findOrFail($id);
        $empresa = ConfiguracionEmpresa::obtener();
        $productoImagenes = $this->getProductoImagenes();

        // Agregar imagenes subidas via el modulo de productos (prioridad sobre estaticas)
        \App\Models\Productos::whereNotNull('imagen')->get()->each(function($p) use (&$productoImagenes) {
            $productoImagenes[mb_strtolower($p->nombre)] = 'storage/' . $p->imagen;
        });

        return view('presupuesto.pdf', compact('presupuesto', 'empresa', 'productoImagenes'));
    }

    /**
     * Descargar PDF del presupuesto
     */
    public function descargarPDF($id)
    {
        $presupuesto = Presupuesto::with('items')->findOrFail($id);
        $empresa = ConfiguracionEmpresa::obtener();
        $productoImagenes = $this->getProductoImagenes('pdf');

        // Agregar imagenes subidas via el modulo de productos (prioridad sobre estaticas)
        \App\Models\Productos::whereNotNull('imagen')->get()->each(function($p) use (&$productoImagenes) {
            $productoImagenes[mb_strtolower($p->nombre)] = 'storage/' . $p->imagen;
        });

        $pdf = Pdf::loadView('presupuesto.pdf-download', compact('presupuesto', 'empresa', 'productoImagenes'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Presupuesto_' . $presupuesto->numero . '.pdf');
    }
}
