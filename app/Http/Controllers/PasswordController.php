<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PasswordController extends Controller
{
    public function index() {
        return view('cambiarpasswords.index');
    }
    
    public function cambiar(Request $request) {
        $request->validate([
            'password' => 'required|min:8|max:30',
        ]);
    
        $usuario = Auth::user();

        if ($usuario instanceof User) {
            // tambien se puede usar Hash::make para encriptar, es igual de seguro
            $usuario->password = bcrypt($request->password);
            $usuario->password_active = 1; // Marcar como activo
            $usuario->save();

            return redirect()->route('dashboard.index')->with('status', 'Contraseña actualizada correctamente.');
        }else {
            return redirect()->back()->withErrors(['error' => 'No hay usuario autenticado o el tipo de objeto es incorrecto.']);
        }
    }
}
