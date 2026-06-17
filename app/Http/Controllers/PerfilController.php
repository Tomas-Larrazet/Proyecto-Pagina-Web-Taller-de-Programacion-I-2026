<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // Validamos que el email sea requerido, válido, y unico en la tabla users, 
            'email' => [
                'required', 
                'email', 
                Rule::unique('users')->ignore($user->id)
            ],
            'password_actual' => 'nullable|required_with:password_nueva|current_password',
            // La nueva contraseña debe tener mínimo 8 caracteres y coincidir con el campo de confirmación
            'password_nueva' => 'nullable|min:8|confirmed',
        ], [
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
            'password_actual.current_password' => 'La contraseña actual no es correcta.',
            'password_nueva.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password_nueva.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        $user->email = $request->email;

        if ($request->filled('password_nueva')) {
            $user->password = Hash::make($request->password_nueva);
        }

        $user->save();

        return back()->with('success', '¡Tu perfil ha sido actualizado correctamente!');
    }
}
