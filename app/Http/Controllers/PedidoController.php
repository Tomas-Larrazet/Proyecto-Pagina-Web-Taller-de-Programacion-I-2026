<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function descargarFactura($id)
    {
        // Buscamos el pedido asegurándonos de que sea del usuario actual
        $pedido = \App\Models\Pedido::with('detalles.producto', 'user')
                                    ->where('user_id', auth()->id())
                                    ->findOrFail($id);

        // Transformamos la vista HTML en PDF
        $pdf = Pdf::loadView('pedidos.factura', compact('pedido'));

        // Forzamos la descarga
        return $pdf->download('Comprobante_Brightness_Nro_'.$pedido->id.'.pdf');
    }
}
