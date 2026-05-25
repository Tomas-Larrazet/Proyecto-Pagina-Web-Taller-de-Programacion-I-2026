<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(){
        // 1. Buscamos todos los productos activos y traemos tambien su categoria (para evitar N+1)
        $productos = Producto::with('categoria')->where('activo', true)->get();

        // 2. Retornamos la vista con los productos
        return view('productos.index', compact('productos'));
    }
}
