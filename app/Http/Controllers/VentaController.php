<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\User;
use App\Notifications\PresupuestoAceptadoNotification;
use App\Notifications\PresupuestoTerminadoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index()
    {
        $query = Presupuesto::with(['items', 'cliente', 'usuario'])
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc');

        // Si el usuario es Fabricante, solo mostrar presupuestos aceptados y entregados
        if (Auth::user()->hasRole('Fabricante')) {
            $query->whereIn('estado', ['aceptado', 'entregado']);
        }

        $presupuestos = $query->get();

        return view('ventas.index', compact('presupuestos'));
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:generado,aceptado,rechazado,entregado',
        ]);

        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->estado = $request->estado;
        $presupuesto->save();

        // Si el estado cambia a "aceptado", notificar al fabricante de la misma tienda del creador
        if ($request->estado === 'aceptado') {
            $tienda = $presupuesto->usuario ? $presupuesto->usuario->tienda : Auth::user()->tienda;
            $fabricante = null;
            if ($tienda) {
                $fabricante = User::role('Fabricante')->where('tienda', $tienda)->first();
            }
            // Fallback: si no encuentra por tienda, buscar cualquier fabricante
            if (!$fabricante) {
                $fabricante = User::role('Fabricante')->first();
            }
            if ($fabricante) {
                $trabajadorNombre = Auth::user()->name;
                try {
                    $fabricante->notify(new PresupuestoAceptadoNotification($presupuesto, $trabajadorNombre));
                } catch (\Exception $e) {
                    // Si el mail falla, la notificación en BD ya fue guardada (es el primer canal)
                }
            }
        }

        // Si el estado cambia a "entregado", notificar al trabajador que creó el presupuesto
        if ($request->estado === 'entregado' && $presupuesto->usuario) {
            try {
                $fabricanteNombre = Auth::user()->name;
                $presupuesto->usuario->notify(new PresupuestoTerminadoNotification($presupuesto, $fabricanteNombre));
            } catch (\Exception $e) {
                // Silenciar error de mail para no bloquear el flujo
            }
        }

        return redirect()->route('dashboard.ventas.index')
            ->with('status', 'Estado del presupuesto Nro ' . $presupuesto->numero . ' actualizado a ' . ucfirst($request->estado));
    }

    public function destroy($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $numero = $presupuesto->numero;
        $presupuesto->items()->delete();
        $presupuesto->delete();

        return redirect()->route('dashboard.ventas.index')
            ->with('status', 'Presupuesto Nro ' . $numero . ' eliminado correctamente');
    }
}
