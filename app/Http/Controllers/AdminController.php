<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Consulta;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            
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
            'activo' => 1 
        ]);

        return redirect()->route('admin.panel')->with('success', '¡Producto cargado con éxito!');
    }
   
    // Elimina un producto (Baja lógica)
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
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

        // 3. Reemplazar foto nueva del usuario
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

    // Muestra la lista de clientes registrados
    public function usuarios()
    {
        // Traemos a todos los usuarios
        $usuarios = User::orderBy('created_at', 'desc')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Muestra el formulario para crear un admin
    public function createAdmin()
    {
        return view('admin.usuarios.crear_admin');
    }

    // Guarda al nuevo administrador en la base de datos
    public function storeAdmin(Request $request)
    {
        // 1. Validamos los datos 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
        ]);

        // 2. Creamos el usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'rol' => 'admin', 
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', '¡Nuevo Administrador creado con éxito!');
    }
}
