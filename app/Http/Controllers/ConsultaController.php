<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    // Este es el método que la guía te pide crear
    public function guardarConsulta(Request $request) 
    { 
        $reglas = [
            'mensaje' => 'required|string|min:10|max:1000',
        ];

        // Validación Dinámica
        if (!Auth::check()) { // Auth::check() devuelve true si está logueado, false si es visitante
            $reglas['nombre'] = 'required|string|max:100';
            $reglas['email'] = 'required|email|max:100';
        }

        $request->validate($reglas);

        if (Auth::check()) {
            $nombreFinal = Auth::user()->name;
            $emailFinal = Auth::user()->email;
        } else {
            // Si es visitante, sacamos los datos de lo que escribió en el formulario
            $nombreFinal = $request->nombre;
            $emailFinal = $request->email;
        }
        
        // Guardar en la base de datos
        Consulta::create([
            'nombre' => $nombreFinal,
            'email' => $emailFinal,
            'mensaje' => $request->mensaje,
        ]);
        

        // Retornamos la vista de éxito pasando un arreglo con los datos
        return view('exito', [ 
            'nombre' => $nombreFinal, 
            'email' => $emailFinal, 
            'mensaje' => $request->mensaje 
        ]); 
    }

    public function procesar1(Request $request)
    {
        return view('exito1');
    }
}