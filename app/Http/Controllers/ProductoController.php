<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index(Request $request){
        // 1. Buscamos todos los productos activos y traemos tambien su categoria (para evitar N+1)
        $query = Producto::with('categoria')->where('activo', true);

        // 2. ¿El usuario filtró por categoría en el dropdown?
        // El request de Laravel atrapa el '?categoria=ID' de la URL
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }

        // 3. Obtenemos los productos ya filtrados
        $productos = $query->get();

        // 4. Buscamos TODAS las categorías de la BD para que el Dropdown pueda dibujarse
        $categoriasDropdown = Categoria::all();

        // 5. Mandamos ambos datos a la vista
        return view('catalogo', compact('productos', 'categoriasDropdown'));
    }
}
