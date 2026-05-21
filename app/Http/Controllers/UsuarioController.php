<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function __invoke()
    {
        return "Ruta por defecto del controlador usuario";
    }

    public function index(){
        $usuarios = User::with('roles') -> get();
        $roles = Role::all();
        return view('usuarios.index', compact(['usuarios','roles']));
    }

    public function store(StoreUserRequest $request){
        $role = Role::find($request->input('role'));
        
        if (!$role || $role->name === 'Administrador') {
            return redirect()->back()->withErrors(['role' => 'Rol no válido.'])->withInput();
        }

        $password = $request->input('password');

        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->tienda = $request->input('tienda');

        $usuario->password = Hash::make($password);
        $usuario->save();

        if ($role) {
            $usuario->assignRole($role);
        }

        Mail::to($usuario->email)->send(new UserCreatedMail($usuario, $password));

        return redirect()->route('dashboard.usuarios.index')->with('status', 'Usuario creado exitosamente.');
    }

    public function edit($usuario)
    {
        $usuario = User::find($usuario);
        return response()->json($usuario);
    }

    public function update(UpdateUserRequest $request, $usuario){

        $usuario = User::find($usuario);

        if ($usuario->roles->contains('name', 'Administrador')) {
            // Si el usuario tiene el rol de administrador, evitar la edición
            return redirect()->back()->withErrors(['error' => 'No se puede editar a administradores.'])->withInput();
        }

        // modifica la verificacion de usuario en caso se quiera cambiar el email
        if ($usuario->email != $request->email){
            $usuario->email_verified_at = null;
            $usuario->email = $request->email;
        }

        $usuario->name = $request->name;
        $usuario->tienda = $request->tienda;
        $role = Role::find($request->role);
        
        if ($role && $role->name !== 'Administrador') {
            $usuario->syncRoles($role); // Usa syncRoles si quieres reemplazar el rol
        } else {
            return redirect()->back()->withErrors(['role' => 'Rol no válido.'])->withInput();
        }

        $usuario->save();
        return redirect()->route('dashboard.usuarios.index')->with('status', 'Usuario actualizado exitosamente.');
    }

    public function updateEnable($usuario){
        
        $usuario = User::find($usuario);

        if ($usuario->roles->contains('name', 'Administrador')) {
            // Si el usuario tiene el rol de administrador, evitar la edición
            return redirect()->back()->withErrors(['error' => 'No se puede deshabilitar a administradores.'])->withInput();
        }

        $is_enable = 'habilitado';

        if($usuario->is_enabled === 0){
            $usuario->is_enabled = 1;
        }else{
            $usuario->is_enabled = 0;
            $is_enable = 'deshabilitado';
        }
        $usuario->save();
        
        return redirect()->route('dashboard.usuarios.index')
                     ->with('status', "Usuario $usuario->name $is_enable correctamente.");
    }

    public function destroy($usuario){
        $usuario = User::find($usuario);

        // Verificar si el usuario a eliminar es el administrador
        if ($usuario->roles->contains('name', 'Administrador')) {
            return redirect()->route('dashboard.usuarios.index')->withErrors(['error' => 'No puedes eliminar al administrador.']);
        }

        $usuario->delete();
        return redirect()->route('dashboard.usuarios.index')->with('status', 'Usuario eliminado exitosamente.');
    }
}
