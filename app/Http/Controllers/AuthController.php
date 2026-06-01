<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.registroUsuario');
    }

    public function showLogin(){
        return view('auth.logIn');
    }

    // Procesa el formulario de registro
    // Procesa el formulario de login
    public function login(Request $request){
        // 1. VALIDACION DE DATOS
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Intentar iniciar sesión
        if (Auth::attempt($credentials, $request->has('remember'))){
            $request->session()->regenerate(); // Previene ataques de sesión

            // 3. MAGIA DE ROLES: Verificamos quién acaba de entrar
            if (Auth::user()->rol === 'admin') {
                // Si es el Administrador, lo mandamos a su panel exclusivo
                return redirect()->intended('/admin/panel'); 
            }

            // Si es un cliente normal, lo mandamos al catálogo
            return redirect()->intended(route('catalogo.index'));
        }

        // 4. Si falla, vuelve atras con el error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Cierra la sesion
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
