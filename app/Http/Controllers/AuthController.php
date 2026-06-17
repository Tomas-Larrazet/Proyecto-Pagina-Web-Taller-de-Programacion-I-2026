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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' exige el campo password_confirmation
            'telefono' => 'nullable|string|max:20|regex:/^[0-9+\-\s]+$/',
            'direccion' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        Auth::login($user);
        return redirect()->route('catalogo.index')->with('success', '¡Te registraste correctamente!');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))){
            $request->session()->regenerate();

            if (Auth::user()->rol === 'admin') {
                return redirect()->intended('/admin/panel-principal'); 
            }
            return redirect()->intended(route('catalogo.index'));
        }

        return back()->with('error', 'No encontramos ninguna cuenta con esos datos, revisa los datos ingresados o registrate.');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
