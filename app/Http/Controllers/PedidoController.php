<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        // 1. Buscamos TODOS los pedidos del usuario logueado.
        // 2. Usamos with('detalles.producto') para traer las tablas conectadas de un solo viaje.
        // 3. Los ordenamos del más nuevo al más viejo.
        $pedidos = Pedido::where('user_id', Auth::id())
                         ->with('detalles.producto') 
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('mis-compras', compact('pedidos'));
    }
}
