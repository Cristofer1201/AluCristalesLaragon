<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Productos;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return "Ruta por defecto del controlador dashboard";
    }

    public function index()
    {
        // Estadísticas generales
        $stats = [
            'totalUsuarios' => User::count(),
            'usuariosActivos' => User::where('is_enabled', true)->count(),
            'totalProductos' => Productos::count(),
            'totalClientes' => Cliente::count(),
            'presupuestosEsteMes' => Presupuesto::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        // Clientes recientes (últimos 5)
        $clientesRecientes = Cliente::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Usuarios recientes (últimos 5)
        $usuariosRecientes = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Actividad reciente (combinada)
        $actividadReciente = collect();

        // Agregar clientes como actividad
        foreach (Cliente::orderBy('created_at', 'desc')->take(3)->get() as $cliente) {
            $actividadReciente->push([
                'tipo' => 'cliente',
                'titulo' => 'Nuevo cliente registrado',
                'descripcion' => $cliente->nombre,
                'fecha' => $cliente->created_at,
                'icono' => 'fa-user-plus',
                'color' => 'success'
            ]);
        }

        // Agregar usuarios como actividad
        foreach (User::orderBy('created_at', 'desc')->take(3)->get() as $usuario) {
            $actividadReciente->push([
                'tipo' => 'usuario',
                'titulo' => 'Usuario creado',
                'descripcion' => $usuario->name,
                'fecha' => $usuario->created_at,
                'icono' => 'fa-user-shield',
                'color' => 'info'
            ]);
        }

        // Ordenar por fecha
        $actividadReciente = $actividadReciente->sortByDesc('fecha')->take(5);

        // Datos para gráficos (clientes por mes - últimos 6 meses)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $chartData['labels'][] = $fecha->translatedFormat('M');
            $chartData['clientes'][] = Cliente::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
            $chartData['usuarios'][] = User::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        return view('dashboard.index', compact(
            'stats',
            'clientesRecientes',
            'usuariosRecientes',
            'actividadReciente',
            'chartData'
        ));
    }
}
