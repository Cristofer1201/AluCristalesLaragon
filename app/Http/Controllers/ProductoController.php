<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(){
        $productos = Productos::orderBy('orden')->get();
        $tipos = Productos::whereNotNull('tipo')->distinct()->pluck('tipo')->sort()->values();

        // Buscar imagen por nombre exacto del producto en public/img/productos/
        $imagenesCategoria = [];
        $imageDir = public_path('img/productos');
        if (is_dir($imageDir)) {
            // Indexar archivos por nombre en minusculas
            $archivosPorNombre = [];
            foreach (scandir($imageDir) as $file) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, ['png', 'jpg', 'jpeg', 'webp'])) continue;
                $archivosPorNombre[mb_strtolower(pathinfo($file, PATHINFO_FILENAME))] = $file;
            }

            foreach ($productos as $producto) {
                // Prioridad 1: imagen subida por el usuario
                if ($producto->imagen) {
                    $imagenesCategoria[$producto->id] = asset('storage/' . $producto->imagen);
                    continue;
                }
                // Prioridad 2: coincidencia exacta por nombre
                $nombreLower = mb_strtolower(trim($producto->nombre));
                if (isset($archivosPorNombre[$nombreLower])) {
                    $imagenesCategoria[$producto->id] = asset('img/productos/' . $archivosPorNombre[$nombreLower]);
                }
            }
        }

        // Imagen representativa por tipo (primera imagen encontrada del tipo)
        $imagenesTipo = [];
        foreach ($tipos as $tipo) {
            foreach ($productos->where('tipo', $tipo) as $p) {
                if (isset($imagenesCategoria[$p->id])) {
                    $imagenesTipo[$tipo] = $imagenesCategoria[$p->id];
                    break;
                }
            }
        }

        $productosJson = $productos->map(function($p) use ($imagenesCategoria) {
            return [
                'id' => $p->id,
                'orden' => $p->orden,
                'tipo' => $p->tipo,
                'nombre' => $p->nombre,
                'descripcion' => $p->descripcion,
                'activo' => $p->activo,
                'imagen' => $imagenesCategoria[$p->id] ?? null,
                'imagen_storage' => $p->imagen ? asset('storage/' . $p->imagen) : '',
                'created_at' => $p->created_at ? $p->created_at->format('d/m/Y') : 'N/A',
            ];
        });

        return view('productos.index', compact('productos', 'imagenesCategoria', 'tipos', 'imagenesTipo', 'productosJson'));
    }

    public function store(StoreProductoRequest $request){

        $producto = new Productos();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->activo = $request->activo;
        $producto->tipo = $request->tipo;

        // Asignar orden: siguiente al máximo actual
        $producto->orden = (Productos::max('orden') ?? 0) + 1;

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $imagenPath;
        }

        $producto->save();

        return redirect()->route('dashboard.productos.index')->with('status', 'Producto creado exitosamente.');
    }

    public function update(Request $request, Productos $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:200',
            'activo' => 'required|boolean',
            'tipo' => 'nullable|string|max:50',
            'imagen' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->activo = $request->activo;
        $producto->tipo = $request->tipo;

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $imagenPath = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $imagenPath;
        }

        $producto->save();

        return redirect()->route('dashboard.productos.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function batchUpdate(Request $request)
    {
        $request->validate([
            'producto_ids' => 'required|array|min:1',
            'producto_ids.*' => 'exists:productos,id',
            'batch_nombre' => 'nullable|string|max:50',
            'batch_descripcion' => 'nullable|string|max:200',
            'batch_tipo' => 'nullable|string|max:50',
            'batch_activo' => 'nullable|in:0,1',
        ]);

        $ids = $request->producto_ids;
        $data = [];

        if ($request->filled('batch_nombre')) {
            $data['nombre'] = $request->batch_nombre;
        }
        if ($request->filled('batch_descripcion')) {
            $data['descripcion'] = $request->batch_descripcion;
        }
        if ($request->filled('batch_tipo')) {
            $data['tipo'] = $request->batch_tipo;
        }
        if ($request->has('batch_activo') && $request->batch_activo !== null && $request->batch_activo !== '') {
            $data['activo'] = $request->batch_activo;
        }

        if (empty($data)) {
            return redirect()->route('dashboard.productos.index')
                ->with('status', 'No se selecciono ningun campo para actualizar.');
        }

        Productos::whereIn('id', $ids)->update($data);

        return redirect()->route('dashboard.productos.index')
            ->with('status', count($ids) . ' producto(s) actualizado(s) correctamente.');
    }

    public function destroy(Productos $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('dashboard.productos.index')
            ->with('status', 'Producto eliminado correctamente.');
    }
}
