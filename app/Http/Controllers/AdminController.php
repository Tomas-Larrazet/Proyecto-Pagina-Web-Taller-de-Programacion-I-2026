<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Consulta;

class AdminController extends Controller
{
    // Muestra el panel principal
    public function index()
    {
        return view('admin.panel'); 
    }

    // Muestra la tabla con todos los productos
    public function productos()
    {
        // Traemos todos los productos de la base de datos
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    // Muestra el formulario para crear un producto
    public function create()
    {
        // Traemos las categorías para armar el menú desplegable
        $categorias = Categoria::all(); 
        return view('admin.productos.create', compact('categorias'));
    }

    // Guarda el producto en la base de datos
    public function store(Request $request)
    {
        // 1. Validamos que no falte nada importante
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048'
        ]);

        //Procesar la imagen
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            // Guarda la foto en la carpeta storage/app/public/productos
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
        }

        // 2. Creamos el producto
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'url_imagen' => $rutaImagen,
            'activo' => 1 // Por defecto nace activo
        ]);

        // 3. Volvemos al panel con un mensaje de éxito
        return redirect()->route('admin.panel')->with('success', '¡Producto cargado con éxito!');
    }
   
    // Elimina un producto (Baja lógica)
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Como el modelo tiene SoftDeletes, esto NO borra el registro de MariaDB. 
        // Solo le pone la fecha actual en la columna 'deleted_at'.
        $producto->delete(); 

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado del catálogo (Baja lógica).');
    }

    // Muestra el formulario con los datos actuales del producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all(); // Necesitamos las categorías para el menú desplegable
        
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    // Sobreescribe los datos en la base de datos
    public function update(Request $request, $id)
    {
        // 1. Validamos los datos nuevos
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $producto = Producto::findOrFail($id);

        // 2. Actualizamos los datos de texto
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria_id;

        // 3. Si el usuario subió una foto nueva, la guardamos y reemplazamos la ruta
        if ($request->hasFile('imagen')) {
            $producto->url_imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->route('admin.productos.index')->with('success', '¡Producto actualizado correctamente!');
    }

    //Muestra el historial completo de ventas
    public function ventas()
    {
        //Traemos todos los pedidos ordenados por fecha 
        $ventas = Pedido::orderBy('created_at', 'desc')->get();

        return  view('admin.ventas.index', compact('ventas'));
    }

    // Muestra el detalle de un pedido específico
    public function showVenta($id)
    {
        // Buscamos el pedido. 
        // Nota: Asumimos que tu compañero armó la relación con los productos o detalles.
        $pedido = Pedido::findOrFail($id);
        
        return view('admin.ventas.show', compact('pedido'));
    }

    // Muestra la bandeja de mensajes de contacto
    public function consultas()
    {
        $consultas = Consulta::orderBy('created_at', 'desc')->get();
        return view('admin.consultas.index', compact('consultas'));
    }
}
