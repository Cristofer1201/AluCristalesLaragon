<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\updatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CambiarContrasenaController extends Controller
{
    public function changePassword()
    {
        $usuario = Auth::user();

        return $usuario->password_active
        ? redirect()->route('dashboard') // Redirige al dashboard si el usuario está habilitado
        : view('auth.change-password');   
    }

    public function updatePassword(updatePasswordRequest $request)
    {
        $usuario = Auth::user();

        if (!Hash::check($request->current_password, $usuario->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        //Condicional para poder usar el metodo save
        if($usuario instanceof User){
            $usuario->password = Hash::make($request->new_password);
            $usuario->password_active = 1; // Marca la contraseña como activa
            $usuario->save();

            return redirect()->route('dashboard')->with('status', 'Contraseña cambiada exitosamente.');

        }else{
            return redirect()->back()->withErrors(['error' => 'No hay usuario autenticado o el tipo de objeto es incorrecto.']);
        }
    }
}
