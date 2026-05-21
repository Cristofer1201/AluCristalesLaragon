<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;


class LoginController extends Controller
{
    // POR REGLA ES MEJOR LLAMAR A LAS VISTAS IGUAL QUE A LAS FUNCIONES
    public function __invoke()
    {
        return "Ruta por defecto del controlador login";
    }

    public function index(){
        return view('login.index');
    }

    // Manejar el inicio de sesión
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        //Limitar los inicios de sesion para evitar ataques de fuerza bruta
        $email = $request->input('email');
        if (RateLimiter::tooManyAttempts($email, 5)) {
            return back()->withErrors([
                'email' => 'Has excedido el número de intentos. Inténtalo de nuevo en unos minutos.',
            ]);
        }

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            RateLimiter::clear($email); //reset a los intentos si se logea exitosamente
            
            // Redirigir al cambio de contraseñas en caso sea su primer inicio de sesion
            if (Auth::user()->password_active == 0) {
                return redirect()->route('cambiarpasswords.index');
            }else{
                return redirect()->intended(route('dashboard.index')); // Cambia 'home' a la ruta de destino
            }
        }

        // Si la autenticación falla, redirigir de nuevo al formulario con un mensaje de error
        return redirect()->back()->withErrors([
            'email' => 'Correo y/o contraseña incorrectos.',
        ]);
    }

    // Manejar el cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
