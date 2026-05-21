<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//necesario para el sistema spatie-permissions
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Trabajador']);

        // Dashboard - acceso general
        Permission::create(['name' => 'dashboard.index'])->syncRoles([$role1, $role2]);

        // Usuarios
        Permission::create(['name' => 'dashboard.usuarios.index'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.usuarios.store'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.usuarios.edit'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.usuarios.update'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.usuarios.updateEnable'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.usuarios.destroy'])->assignRole($role1);

        // Roles y Permisos
        Permission::create(['name' => 'dashboard.roles.index'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.roles.store'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.roles.update'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.roles.destroy'])->assignRole($role1);

        // Clientes
        Permission::create(['name' => 'dashboard.clientes.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.clientes.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.clientes.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.clientes.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.clientes.destroy'])->assignRole($role1);

        // Productos
        Permission::create(['name' => 'dashboard.productos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.productos.store'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.productos.edit'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.productos.update'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.productos.destroy'])->assignRole($role1);

        // Presupuestos
        Permission::create(['name' => 'dashboard.presupuesto.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.presupuesto.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.presupuesto.pdf'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.presupuesto.descargar'])->syncRoles([$role1, $role2]);

        // Ventas
        Permission::create(['name' => 'dashboard.ventas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.ventas.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'dashboard.ventas.destroy'])->assignRole($role1);

        // Plantilla PDF
        Permission::create(['name' => 'dashboard.plantilla-pdf.index'])->assignRole($role1);
        Permission::create(['name' => 'dashboard.plantilla-pdf.update'])->assignRole($role1);
    }
}