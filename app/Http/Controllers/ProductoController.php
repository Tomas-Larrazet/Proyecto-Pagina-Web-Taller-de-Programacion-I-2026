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

        // 4. FILTRO C: ¿El usuario pidió ver solo lo que hay en stock?
        if ($request->has('en_stock') && $request->en_stock == '1') {
            $query->where('stock', '>', 0);
        }

        // 5. FILTRO NUEVO: Rango de Precios (Mínimo y Máximo)
        if ($request->has('precio_min') && $request->precio_min != '') {
            $query->where('precio', '>=', $request->precio_min);
        }
        
        if ($request->has('precio_max') && $request->precio_max != '') {
            $query->where('precio', '<=', $request->precio_max);
        }

        // 6. FILTRO C: Ordenamiento por Precio
        if ($request->has('orden_precio') && $request->orden_precio != '') {
            if ($request->orden_precio == 'menor') {
                $query->orderBy('precio', 'asc'); // Ascendente: de más barato a más caro
            } elseif ($request->orden_precio == 'mayor') {
                $query->orderBy('precio', 'desc'); // Descendente: de más caro a más barato
            }
        } else {
            // Ordenamiento por defecto (si no elige nada, mostramos los más nuevos primero)
            $query->orderBy('id', 'desc'); 
        }

        // 7. Obtenemos los productos con todos los filtros aplicados
        $productos = $query->get();

        // 8. Buscamos TODAS las categorías para el Dropdown lateral
        $categoriasDropdown = Categoria::all();

        // 9. Mandamos ambos datos a la vista 'catalogo'
        return view('catalogo', compact('productos', 'categoriasDropdown'));
    }
}
