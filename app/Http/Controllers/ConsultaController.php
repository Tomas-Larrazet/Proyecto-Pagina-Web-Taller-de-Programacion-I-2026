<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function guardarConsulta(Request $request) 
    { 
        $reglas = [
            'mensaje' => 'required|string|min:10|max:1000',
        ];

        if (!Auth::check()) {
            $reglas['nombre'] = 'required|string|max:100';
            $reglas['email'] = 'required|email|max:100';
        }

        $request->validate($reglas);

        if (Auth::check()) {
            $nombreFinal = Auth::user()->name;
            $emailFinal = Auth::user()->email;
        } else {
            $nombreFinal = $request->nombre;
            $emailFinal = $request->email;
        }
        
        Consulta::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'nombre' => $nombreFinal,
            'email' => $emailFinal,
            'mensaje' => $request->mensaje,
        ]);
        
        return view('exito', [ 
            'nombre' => $nombreFinal, 
            'email' => $emailFinal, 
            'mensaje' => $request->mensaje 
        ]); 
    }

}