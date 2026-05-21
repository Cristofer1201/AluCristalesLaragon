<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        // Agrupar permisos por módulo
        $permisosAgrupados = [];
        $modulos = [
            'dashboard' => 'Dashboard',
            'usuarios' => 'Usuarios',
            'roles' => 'Roles y Permisos',
            'clientes' => 'Clientes',
            'productos' => 'Productos',
            'presupuesto' => 'Presupuestos',
            'ventas' => 'Ventas',
            'plantilla-pdf' => 'Plantilla PDF',
        ];

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);
            // dashboard.modulo.accion => modulo es parts[1]
            $modulo = $parts[1] ?? 'general';
            $accion = $parts[2] ?? $parts[1] ?? $permission->name;

            $nombreModulo = $modulos[$modulo] ?? ucfirst($modulo);
            $permisosAgrupados[$nombreModulo][] = $permission;
        }

        return view('roles.index', compact('roles', 'permisosAgrupados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('dashboard.roles.index')
            ->with('status', 'Rol creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Administrador') {
            return redirect()->route('dashboard.roles.index')
                ->withErrors('No se puede modificar el rol Administrador.');
        }

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
        ]);

        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('dashboard.roles.index')
            ->with('status', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Administrador') {
            return redirect()->route('dashboard.roles.index')
                ->withErrors('No se puede eliminar el rol Administrador.');
        }

        if ($role->users->count() > 0) {
            return redirect()->route('dashboard.roles.index')
                ->withErrors('No se puede eliminar el rol porque tiene usuarios asignados.');
        }

        $role->delete();

        return redirect()->route('dashboard.roles.index')
            ->with('status', 'Rol eliminado correctamente.');
    }
}