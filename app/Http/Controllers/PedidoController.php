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
        $pedidos = Pedido::where('user_id', Auth::id())
                         ->with('detalles.producto') 
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('mis-compras', compact('pedidos'));
    }

    public function descargarFactura($id)
    {
        $pedido = \App\Models\Pedido::with('detalles.producto', 'user')
                                    ->where('user_id', auth()->id())
                                    ->findOrFail($id);

        $pdf = Pdf::loadView('pedidos.factura', compact('pedido'));

        return $pdf->download('Comprobante_Brightness_Nro_'.$pedido->id.'.pdf');
    }
}
