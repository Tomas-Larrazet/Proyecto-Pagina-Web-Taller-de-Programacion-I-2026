<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;        
use App\Models\DetallePedido; 
use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    // 1. AGREGAR AL CARRITO
    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);

        // ¡Bloqueo para Administradores!
        if (Auth::user()->rol === 'admin') { 
            return back()->with('error', 'Las cuentas de administrador no pueden realizar compras.');
        }

        if ($producto->stock <= 0) {
            return redirect()->back()->with('error', 'Lamentablemente no hay stock de este producto.');
        }

        $itemCarrito = Carrito::where('user_id', Auth::id())
                              ->where('producto_id', $id)
                              ->first();

        if ($itemCarrito) {
            if ($itemCarrito->cantidad < $producto->stock) {
                $itemCarrito->cantidad++;
                $itemCarrito->save();
                return back()->with('success', 'Sumaste otra unidad al carrito.');
            } else {
                return back()->with('error', 'No puedes agregar más unidades del stock disponible.');
            }
        } else {
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
        $carrito = Carrito::with('producto')->where('user_id', Auth::id())->get();
        
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item->producto->precio * $item->cantidad;
        }

        // Revisamos si el cliente tiene un descuento guardado en sesión
        $porcentajeDescuento = session()->get('descuento_porcentaje', 0);
        $montoDescuento = ($subtotal * $porcentajeDescuento) / 100;
        
        // Calculamos el total final
        $total = $subtotal - $montoDescuento;

        return view('carrito.index', compact('carrito', 'subtotal', 'montoDescuento', 'total', 'porcentajeDescuento'));
    }

    // 3. ELIMINAR UN PRODUCTO
    public function eliminar($id)
    {
        Carrito::where('user_id', Auth::id())->where('producto_id', $id)->delete();
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    // 4. VACIAR TODO EL CARRITO
    public function vaciar()
    {
        Carrito::where('user_id', Auth::id())->delete();
        return back()->with('success', 'El carrito ha sido vaciado.');
    }

    // 5. CONFIRMAR COMPRA 
    public function comprar()
    {
        $carrito = Carrito::with('producto')->where('user_id', Auth::id())->get();

        // Bloqueo de seguridad extra por si intentan forzar la URL
        if (Auth::user()->rol === 'admin') { 
            return back()->with('error', 'Las cuentas de administrador no pueden realizar compras.');
        }

        $carrito = Carrito::with('producto')->where('user_id', Auth::id())->get();

        if ($carrito->isEmpty()) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            foreach ($carrito as $item) {
                $subtotal += $item->producto->precio * $item->cantidad;
            }

            // Aplicamos el descuento al total real que se va a guardar en la BD
            $porcentajeDescuento = session()->get('descuento_porcentaje', 0);
            $montoDescuento = ($subtotal * $porcentajeDescuento) / 100;
            $totalFinal = $subtotal - $montoDescuento;

            // A) Creamos el PEDIDO general (Guardando el Total Final con descuento)
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $totalFinal,
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

            // Limpiamos el cupón usado para que no aplique a la próxima compra
            session()->forget('descuento_porcentaje');

            DB::commit();

            DB::commit();

            // Pasamos el ID del pedido recién creado a la nueva ruta
            return redirect()->route('compra.exitosa', $pedido->id);

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

    // 7. APLICAR CUPÓN DE DESCUENTO
    public function aplicarCupon(Request $request)
    {
        $codigo = strtoupper($request->input('codigo_cupon'));

        if ($codigo === 'BRIGHTNESS') {
            
            // ¡LA NUEVA VALIDACIÓN!
            // Contamos cuántos pedidos tiene este usuario en su historial
            $comprasPrevias = \App\Models\Pedido::where('user_id', auth()->id())->count();

            if ($comprasPrevias > 0) {
                // Si tiene 1 o más, le rebotamos el cupón
                return back()->with('error', 'El cupón BRIGHTNESS es válido únicamente para tu primera compra.');
            }

            // Si tiene 0 compras, le damos el descuento
            session()->put('descuento_porcentaje', 10); 
            return back()->with('success', '¡Cupón BRIGHTNESS aplicado! Tenés un 10% de descuento.');
        }

        return back()->with('error', 'El código ingresado no es válido.');
    }

    
    //Redireccion a pagina exitosa
    public function compraExitosa($id)
    {
        // Buscamos el pedido con sus detalles para mostrarlos en la pantalla de agradecimiento
        $pedido = Pedido::with('detalles.producto')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('carrito.exito', compact('pedido'));
    }

}



