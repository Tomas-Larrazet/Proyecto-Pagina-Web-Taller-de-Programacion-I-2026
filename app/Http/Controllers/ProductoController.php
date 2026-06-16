<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Carrito;

class ProductoController extends Controller
{
    public function index(Request $request){
        $query = Producto::with('categoria')->where('activo', true);

        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->has('buscar') && $request->buscar != '') {
            $busqueda = $request->buscar;
            
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('descripcion', 'LIKE', '%' . $busqueda . '%');
            });
        }

        if ($request->has('en_stock') && $request->en_stock == '1') {
            $query->where('stock', '>', 0);
        }

        if ($request->has('precio_min') && $request->precio_min != '') {
            $query->where('precio', '>=', $request->precio_min);
        }
        
        if ($request->has('precio_max') && $request->precio_max != '') {
            $query->where('precio', '<=', $request->precio_max);
        }

        if ($request->has('orden_precio') && $request->orden_precio != '') {
            if ($request->orden_precio == 'menor') {
                $query->orderBy('precio', 'asc');
            } elseif ($request->orden_precio == 'mayor') {
                $query->orderBy('precio', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc'); 
        }

        $productos = $query->get();

        $categoriasDropdown = Categoria::all();

        $carrito = auth()->check() 
            ? \App\Models\Carrito::where('user_id', auth()->id())->pluck('cantidad', 'producto_id')
            : collect();

        return view('catalogo', compact('productos', 'categoriasDropdown', 'carrito'));
    }
}
