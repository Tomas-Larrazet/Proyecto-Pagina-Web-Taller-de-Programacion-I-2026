<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;        
use App\Models\DetallePedido; 
use App\Models\Carrito; // ¡Importamos el modelo nuevo!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    // 1. AGREGAR AL CARRITO
    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->stock <= 0) {
            return back()->with('error', 'Lamentablemente no hay stock de este producto.');
        }

        // Buscamos si ESTE usuario ya tiene ESTE producto en su carrito
        $itemCarrito = Carrito::where('user_id', Auth::id())
                              ->where('producto_id', $id)
                              ->first();

        if ($itemCarrito) {
            // Ya lo tiene: le sumamos 1 si hay stock
            if ($itemCarrito->cantidad < $producto->stock) {
                $itemCarrito->cantidad++;
                $itemCarrito->save();
                return back()->with('success', 'Sumaste otra unidad al carrito.');
            } else {
                return back()->with('error', 'No puedes agregar más unidades del stock disponible.');
            }
        } else {
            // No lo tiene: creamos el registro en la base de datos
            Carrito::create([
                'user_id' => Auth::id(),
                'producto_id' => $id,
                'cantidad' => 1
            ]);
            return back()->with('success', '¡Producto agregado al carrito!');
        }
    }

    // 2. VER CARRITO
    public function ver()
    {
        // Traemos todo el carrito del usuario logueado, e incluimos los datos del producto
        $carrito = Carrito::with('producto')->where('user_id', Auth::id())->get();
        
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item->producto->precio * $item->cantidad;
        }

        return view('carrito.index', compact('carrito', 'total'));
    }

    // 3. ELIMINAR UN PRODUCTO
    public function eliminar($id)
    {
        // Borramos el registro que coincide con el ID del producto y el ID del usuario
        Carrito::where('user_id', Auth::id())->where('producto_id', $id)->delete();

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    // 4. VACIAR TODO EL CARRITO
    public function vaciar()
    {
        // Borramos TODOS los registros de este usuario
        Carrito::where('user_id', Auth::id())->delete();
        return back()->with('success', 'El carrito ha sido vaciado.');
    }

    // 5. CONFIRMAR COMPRA 
    public function comprar()
    {
        $carrito = Carrito::with('producto')->where('user_id', Auth::id())->get();

        if ($carrito->isEmpty()) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item->producto->precio * $item->cantidad;
            }

            // A) Creamos el PEDIDO general
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'estado' => 'pendiente',
            ]);

            // B) Creamos los DETALLES y restamos el STOCK
            foreach ($carrito as $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                ]);

                // Descontamos stock
                $producto = $item->producto;
                $producto->stock -= $item->cantidad;
                $producto->save();
            }

            // C) Vaciamos el carrito de la base de datos
            Carrito::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect('/mis-compras')->with('success', '¡Compra realizada con éxito! Gracias por elegir Brightness.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar tu compra. Por favor, intenta de nuevo.');
        }
    }

    // 6. ACTUALIZAR CANTIDADES 
    public function actualizar(Request $request, $id)
    {
        $itemCarrito = Carrito::with('producto')
                              ->where('user_id', Auth::id())
                              ->where('producto_id', $id)
                              ->first();

        if ($itemCarrito) {
            $accion = $request->input('accion');

            if ($accion === 'sumar') {
                if ($itemCarrito->cantidad < $itemCarrito->producto->stock) {
                    $itemCarrito->cantidad++;
                    $itemCarrito->save();
                    return back()->with('success', 'Cantidad actualizada.');
                } else {
                    return back()->with('error', 'No hay más stock disponible.');
                }
            } elseif ($accion === 'restar') {
                if ($itemCarrito->cantidad > 1) {
                    $itemCarrito->cantidad--;
                    $itemCarrito->save();
                    return back()->with('success', 'Cantidad reducida.');
                } else {
                    return back()->with('error', 'La cantidad mínima es 1. Usa el ícono de basura si querés quitar el producto.');
                }
            }
        }

        return back();
    }
}
