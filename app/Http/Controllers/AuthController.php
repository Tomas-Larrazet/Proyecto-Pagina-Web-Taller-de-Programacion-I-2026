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
    public function register(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' exige el campo password_confirmation
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // 2. CREACIÓN DEL USUARIO
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptación obligatoria
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        // 3. LOGUEAR AUTOMÁTICAMENTE Y REDIRIGIR
        Auth::login($user);
        return redirect()->route('catalogo.index')->with('success', '¡Te registraste correctamente!');
    }

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

            // 3.Verificamos quién acaba de entrar
            if (Auth::user()->rol === 'admin') {
                // Si es el Administrador, va a su panel exclusivo
                return redirect()->intended('/admin/panel-principal'); 
            }

            // Si es un cliente normal, lo mandamos al catálogo
            return redirect()->intended(route('catalogo.index'));
        }

        // 4. Si falla, vuelve atras con el error
        return back()->with('error', 'No encontramos ninguna cuenta con esos datos, revisa los datos ingresados o registrate.');
    }

    // Cierra la sesion
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
