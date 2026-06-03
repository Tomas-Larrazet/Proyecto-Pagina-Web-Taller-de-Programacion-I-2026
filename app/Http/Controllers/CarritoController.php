<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;        
use App\Models\DetallePedido; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Para transacciones seguras

class CarritoController extends Controller
{
    // 1. AGREGAR AL CARRITO
    public function agregar($id)
    {
        $producto = Producto::findOrFail($id);

        // Verificamos el stock real por seguridad (el front ya lo bloquea, pero el back debe confirmarlo)
        if ($producto->stock <= 0) {
            return back()->with('error', 'Lamentablemente no hay stock de este producto.');
        }

        // Traemos el carrito actual de la sesión (si no existe, crea un array vacío)
        $carrito = session()->get('carrito', []);

        // Si el producto ya está en el carrito, le sumamos 1 a la cantidad
        if (isset($carrito[$id])) {
            // Chequeamos que no intente agregar más del stock disponible
            if ($carrito[$id]['cantidad'] < $producto->stock) {
                $carrito[$id]['cantidad']++;
            } else {
                return back()->with('error', 'No puedes agregar más unidades del stock disponible.');
            }
        } else {
            // Si no está, lo agregamos por primera vez
            $carrito[$id] = [
                'nombre' => $producto->nombre,
                'cantidad' => 1,
                'precio' => $producto->precio,
                'url_imagen' => $producto->url_imagen
            ];
        }

        // Guardamos el array actualizado en la sesión
        session()->put('carrito', $carrito);
        return back()->with('success', '¡Producto agregado al carrito!');
    }

    // 2. VER CARRITO
    public function ver()
    {
        $carrito = session()->get('carrito', []);
        
        // Calcular el total
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('carrito.index', compact('carrito', 'total'));
    }

    // 3. ELIMINAR UN PRODUCTO
    public function eliminar($id)
    {
        $carrito = session()->get('carrito');

        if (isset($carrito[$id])) {
            unset($carrito[$id]); // Lo borramos del array
            session()->put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    // 4. VACIAR TODO EL CARRITO
    public function vaciar()
    {
        session()->forget('carrito'); // Destruye la variable de sesión
        return back()->with('success', 'El carrito ha sido vaciado.');
    }

    // 5. CONFIRMAR COMPRA 
    public function comprar()
    {
        $carrito = session()->get('carrito');

        if (!$carrito) {
            return back()->with('error', 'Tu carrito está vacío.');
        }

        // Usamos una Transacción de Base de Datos. Si algo falla a la mitad, se cancela todo para no dejar datos rotos.
        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            // A) Creamos el PEDIDO general
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'estado' => 'pendiente', // O 'pagado', 'enviado', etc.
            ]);

            // B) Creamos los DETALLES y restamos el STOCK
            foreach ($carrito as $id => $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                // Descontar stock del catálogo
                $producto = Producto::find($id);
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            // Todo salió bien, confirmamos los cambios en MariaDB
            DB::commit();

            // C) Vaciamos el carrito
            session()->forget('carrito');

            return redirect('/mis-compras')->with('success', '¡Compra realizada con éxito! Gracias por elegir Brightness.');

        } catch (\Exception $e) {
            // Si hubo un error, cancelamos las escrituras en la base de datos
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar tu compra. Por favor, intenta de nuevo.');
        }
    }

    // ACTUALIZAR CANTIDADES 
    public function actualizar(Request $request, $id)
    {
        $carrito = session()->get('carrito');

        if (isset($carrito[$id])) {
            $producto = \App\Models\Producto::find($id);
            $accion = $request->input('accion');

            if ($accion === 'sumar') {
                // Verificamos que haya stock suficiente para sumar otro
                if ($carrito[$id]['cantidad'] < $producto->stock) {
                    $carrito[$id]['cantidad']++;
                    session()->put('carrito', $carrito);
                    return back()->with('success', 'Cantidad actualizada.');
                } else {
                    return back()->with('error', 'No hay más stock disponible de este producto.');
                }
            } elseif ($accion === 'restar') {
                // Solo restamos si hay más de 1. Si es 1, se usa el botón de la papelera para eliminar.
                if ($carrito[$id]['cantidad'] > 1) {
                    $carrito[$id]['cantidad']--;
                    session()->put('carrito', $carrito);
                    return back()->with('success', 'Cantidad reducida.');
                } else {
                    return back()->with('error', 'La cantidad mínima es 1. Usa el ícono de basura si querés quitar el producto.');
                }
            }
        }

        return back();
    }
}
