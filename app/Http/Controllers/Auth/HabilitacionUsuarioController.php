<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabilitacionUsuarioController extends Controller
{
    public function habilitacion(){
        $user = Auth::user();

        if ($user && $user->is_enabled === 1) {
            // Si el usuario ya está habilitado, redirige al dashboard
            return redirect()->route('dashboard');
        }

        return view('auth.wait-to-enable-user');
    }
}
