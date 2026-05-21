<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Mostrar vista de clientes registrados
     */
    public function indexView()
    {
        $clientes = Cliente::orderBy('id', 'desc')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Obtener todos los clientes (para select/búsqueda - API)
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return response()->json($clientes);
    }

    /**
     * Buscar clientes por nombre
     */
    public function buscar(Request $request)
    {
        $query = $request->get('q', '');
        $clientes = Cliente::where('nombre', 'like', "%{$query}%")
            ->orderBy('nombre')
            ->limit(10)
            ->get();
        return response()->json($clientes);
    }

    /**
     * Guardar nuevo cliente
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:50',
        ]);

        $cliente = Cliente::create($request->all());

        return response()->json([
            'success' => true,
            'cliente' => $cliente,
            'message' => 'Cliente guardado correctamente'
        ]);
    }

    /**
     * Obtener un cliente específico
     */
    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    /**
     * Actualizar cliente (API)
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:50',
        ]);

        $cliente->update($request->all());

        return response()->json([
            'success' => true,
            'cliente' => $cliente,
            'message' => 'Cliente actualizado correctamente'
        ]);
    }

    /**
     * Guardar nuevo cliente (Web)
     */
    public function storeWeb(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:50',
        ]);

        Cliente::create($request->all());

        return redirect()->route('dashboard.clientes.index')
            ->with('status', 'Cliente registrado correctamente');
    }

    /**
     * Actualizar cliente (Web)
     */
    public function updateWeb(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:50',
        ]);

        $cliente->update($request->all());

        return redirect()->route('dashboard.clientes.index')
            ->with('status', 'Cliente actualizado correctamente');
    }

    /**
     * Eliminar cliente (Web)
     */
    public function destroyWeb(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('dashboard.clientes.index')
            ->with('status', 'Cliente eliminado correctamente');
    }
}
