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
    public function register(Request $request){
        
        // 1. VALIDACION DE DATOS
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        
        // 2. CREAR USUARIO
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), //Encriptacion de la contraseña
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);
        // 3. LOGUEAR AUTOMATICAMENTE Y REDIRIGIR
        Auth::login($user);
        return redirect('/exito1')->with('success', 'Registro exitoso. ¡Bienvenido a Brightness Store!');
    }

    // Procesa el formulario de login
    public function login(Request $request){
        // 1. VALIDACION DE DATOS
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Intentar iniciar sesión (Auth::attempt busca en la BD y compara contraseñas)
        if (Auth::attempt($credentials, $request->has('remember'))){
            $request->session()->regenerate(); // Previene ataques de sesión
            return redirect()->intended(route('catalogo.index'));
        }

        // 3. Si falla, vuelve atras con el error
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
