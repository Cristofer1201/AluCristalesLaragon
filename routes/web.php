<?php

use App\Http\Controllers\Auth\CambiarContrasenaController;
use App\Http\Controllers\Auth\HabilitacionUsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MedidaController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PlantillaPdfController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware(['auth'])->group(function () {
    // Ruta para mostrar el formulario de cambio de contraseña
    Route::get('/cambiar-contrasena', [CambiarContrasenaController::class, 'changePassword'])->name('contrasena.change');

    // Ruta para procesar el cambio de contraseña
    Route::post('/cambiar-contrasena', [CambiarContrasenaController::class, 'updatePassword'])->name('contrasena.update');
});

Route::middleware(['auth', 'password.active'])->group(function () {
    Route::get('dashboard/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('dashboard/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('dashboard/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'password.active'])->group(function () {
    Route::get('/habilitacion', [HabilitacionUsuarioController::class, 'habilitacion'])->name('usuario.habilitacion');
});

Route::middleware(['auth', 'password.active', 'user.enabled'])->group(function () {
    //DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //USUARIOS
    Route::get('/dashboard/usuarios', [UsuarioController::class, 'index']) ->middleware('can:dashboard.usuarios.index') ->name('dashboard.usuarios.index');
    Route::post('/dashboard/usuarios', [UsuarioController::class, 'store']) ->middleware('can:dashboard.usuarios.store') ->name('dashboard.usuarios.store');
    Route::get('/dashboard/usuarios/{usuario}/edit', [UsuarioController::class, 'edit']) ->middleware('can:dashboard.usuarios.edit') ->name('dashboard.usuarios.edit');
    Route::put('/dashboard/usuarios/{usuario}', [UsuarioController::class, 'update']) ->middleware('can:dashboard.usuarios.update') ->name('dashboard.usuarios.update');
    Route::put('/dashboard/usuarios/{usuario}/enabled', [UsuarioController::class, 'updateEnable']) ->middleware('can:dashboard.usuarios.updateEnable') ->name('dashboard.usuarios.updateEnable');
    Route::delete('/dashboard/usuarios/{usuario}', [UsuarioController::class, 'destroy']) ->middleware('can:dashboard.usuarios.destroy') ->name('dashboard.usuarios.destroy');

    //ROLES Y PERMISOS
    Route::get('/dashboard/roles', [RolController::class, 'index']) ->middleware('can:dashboard.roles.index') ->name('dashboard.roles.index');
    Route::post('/dashboard/roles', [RolController::class, 'store']) ->middleware('can:dashboard.roles.store') ->name('dashboard.roles.store');
    Route::put('/dashboard/roles/{rol}', [RolController::class, 'update']) ->middleware('can:dashboard.roles.update') ->name('dashboard.roles.update');
    Route::delete('/dashboard/roles/{rol}', [RolController::class, 'destroy']) ->middleware('can:dashboard.roles.destroy') ->name('dashboard.roles.destroy');

    //PRODUCTOS
    
    Route::get('/dashboard/productos', [ProductoController::class, 'index']) ->middleware('can:dashboard.productos.index') ->name('dashboard.productos.index');
    Route::post('/dashboard/productos', [ProductoController::class, 'store']) ->middleware('can:dashboard.productos.store') ->name('dashboard.productos.store');
    Route::get('/dashboard/productos/{producto}/edit', [ProductoController::class, 'edit']) ->middleware('can:dashboard.productos.edit') ->name('dashboard.productos.edit');
    Route::put('/dashboard/productos/{producto}', [ProductoController::class, 'update'])->middleware('can:dashboard.productos.update') ->name('dashboard.productos.update');
    Route::delete('/dashboard/productos/{producto}', [ProductoController::class, 'destroy']) ->middleware('can:dashboard.productos.destroy') ->name('dashboard.productos.destroy');
    Route::put('/dashboard/productos-lote', [ProductoController::class, 'batchUpdate'])->middleware('can:dashboard.productos.update')->name('dashboard.productos.batchUpdate');
    

    //PRESUPUESTO
    Route::get('/dashboard/presupuesto', [PresupuestoController::class, 'index']) ->name('dashboard.presupuesto.index');
    Route::get('/dashboard/presupuesto/{id}/pdf', [PresupuestoController::class, 'mostrarPDF']) ->name('dashboard.presupuesto.pdf');
    Route::get('/dashboard/presupuesto/{id}/descargar-pdf', [PresupuestoController::class, 'descargarPDF']) ->name('dashboard.presupuesto.descargar-pdf');
    Route::put('/api/presupuesto/{id}/actualizar', [PresupuestoController::class, 'actualizar'])->name('api.presupuesto.actualizar');

    //VENTAS
    Route::get('/dashboard/ventas', [VentaController::class, 'index'])->name('dashboard.ventas.index');
    Route::put('/dashboard/ventas/{id}/estado', [VentaController::class, 'updateEstado'])->name('dashboard.ventas.updateEstado');
    Route::delete('/dashboard/ventas/{id}', [VentaController::class, 'destroy'])->name('dashboard.ventas.destroy');

    //NOTIFICACIONES
    Route::post('/notificaciones/{id}/leer', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('dashboard.ventas.index');
    })->name('notifications.read');
    Route::post('/notificaciones/leer-todas', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.readAll');

    //PLANTILLA PDF
    Route::get('/dashboard/plantilla-pdf', [PlantillaPdfController::class, 'index'])->name('dashboard.plantilla-pdf.index');
    Route::put('/dashboard/plantilla-pdf', [PlantillaPdfController::class, 'update'])->name('dashboard.plantilla-pdf.update');

    //CLIENTES REGISTRADOS (Modulo de gestion)
    Route::get('/dashboard/clientes', [ClienteController::class, 'indexView']) ->middleware('can:dashboard.clientes.index') ->name('dashboard.clientes.index');
    Route::post('/dashboard/clientes', [ClienteController::class, 'storeWeb']) ->middleware('can:dashboard.clientes.store') ->name('dashboard.clientes.store');
    Route::put('/dashboard/clientes/{cliente}', [ClienteController::class, 'updateWeb']) ->middleware('can:dashboard.clientes.update') ->name('dashboard.clientes.update');
    Route::delete('/dashboard/clientes/{cliente}', [ClienteController::class, 'destroyWeb']) ->middleware('can:dashboard.clientes.destroy') ->name('dashboard.clientes.destroy');

    //CLIENTES (API para presupuesto)
    Route::get('/api/clientes', [ClienteController::class, 'index'])->name('api.clientes.index');
    Route::get('/api/clientes/buscar', [ClienteController::class, 'buscar'])->name('api.clientes.buscar');
    Route::post('/api/clientes', [ClienteController::class, 'store'])->name('api.clientes.store');
    Route::get('/api/clientes/{cliente}', [ClienteController::class, 'show'])->name('api.clientes.show');
    Route::put('/api/clientes/{cliente}', [ClienteController::class, 'update'])->name('api.clientes.update');

    //PRESUPUESTO (API)
    Route::get('/api/presupuesto/siguiente-numero', [PresupuestoController::class, 'siguienteNumero'])->name('api.presupuesto.siguienteNumero');
    Route::post('/api/presupuesto/guardar', [PresupuestoController::class, 'guardar'])->name('api.presupuesto.guardar');
    Route::get('/api/presupuesto/configuracion-empresa', [PresupuestoController::class, 'configuracionEmpresa'])->name('api.presupuesto.configuracionEmpresa');

});

/*
//LOGIN
Route::get('/login', [LoginController::class, 'index']) -> name('login');
Route::post('/login', [LoginController::class, 'login']) -> name('login.login');
Route::post('/logout', [LoginController::class, 'logout']) -> name('logout');

//PASSWORD
Route::get('/cambiar-contrasena', [PasswordController::class, 'index']) -> name('cambiarpasswords.index');
Route::post('/cambiar-contrasena', [PasswordController::class, 'cambiar']) -> name('cambiarpasswords.cambiar');
*/




require __DIR__ . '/auth.php';
