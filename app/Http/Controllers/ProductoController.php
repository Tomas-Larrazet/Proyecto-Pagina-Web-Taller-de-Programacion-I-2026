<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index(Request $request){
        // 1. Iniciamos la consulta base (¡Con Eager Loading y solo productos activos!)
        $query = Producto::with('categoria')->where('activo', true);

        // 2. FILTRO A: ¿El usuario filtró por categoría en el dropdown?
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }

        // 3. FILTRO B: ¿El usuario escribió algo en el nuevo Buscador?
        if ($request->has('buscar') && $request->buscar != '') {
            $busqueda = $request->buscar;
            
            // Agrupamos el OR dentro de una función para no romper el filtro de 'activo' o 'categoria'
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('descripcion', 'LIKE', '%' . $busqueda . '%');
            });
        }

        // 4. Obtenemos los productos con todos los filtros aplicados
        $productos = $query->get();

        // 5. Buscamos TODAS las categorías para el Dropdown lateral
        $categoriasDropdown = Categoria::all();

        // 6. Mandamos ambos datos a la vista 'catalogo'
        return view('catalogo', compact('productos', 'categoriasDropdown'));
    }
}
