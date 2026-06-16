<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Consulta;
use App\Models\User;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $totalUsuarios = User::count();

        $totalProductos = Producto::count();

        $totalVentas = Pedido::count();

        $ingresos = Pedido::sum('total');

        $productosStockBajo = Producto::where('stock','<=',5)
        ->get();

        $topProductos = DetallePedido::select(
        'producto_id',
        \DB::raw('SUM(cantidad) as total_vendido')
        )
        ->groupBy('producto_id')
        ->orderByDesc('total_vendido')
        ->with('producto')
        ->limit(5)
        ->get();

        return view('admin.panel-principal', compact(
            'totalUsuarios',
            'totalProductos',
            'totalVentas',
            'ingresos',
            'productosStockBajo',
            'topProductos'
        ));
    }

    public function productos()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all(); 
        return view('admin.productos.create', compact('categorias'));
    }

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

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'url_imagen' => $rutaImagen,
            'activo' => 1 
        ]);

        return redirect()->route('admin.panel-principal')->with('success', '¡Producto cargado con éxito!');
    }
   
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        $producto->delete(); 

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado del catálogo (Baja lógica).');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $producto = Producto::findOrFail($id);

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagen')) {
            $producto->url_imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->route('admin.productos.index')->with('success', '¡Producto actualizado correctamente!');
    }

    public function ventas()
    {
        $ventas = Pedido::orderBy('created_at', 'desc')->get();

        return  view('admin.ventas.index', compact('ventas'));
    }

    public function showVenta($id)
    {
        $pedido = Pedido::findOrFail($id);
        
        return view('admin.ventas.show', compact('pedido'));
    }

    public function cambiarEstado(Request $request, $id){
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'estado'=>'required|in:pendiente,pagado,enviado,entregado,cancelado'
        ]);

        $pedido->estado = $request->estado;
        $pedido->save();

        return redirect()->back()->with('success','Estado actualizado correctamente');
    }

    public function consultas()
    {
        $consultas = Consulta::orderBy('created_at', 'desc')->get();
        return view('admin.consultas.index', compact('consultas'));
    }

    public function usuarios()
    {
        $usuarios = User::orderBy('created_at', 'desc')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function createAdmin()
    {
        return view('admin.usuarios.crear_admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'rol' => 'admin', 
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', '¡Nuevo Administrador creado con éxito!');
    }

    public function destroyUser($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'Por seguridad, no podés dar de baja tu propia cuenta.');
        }

        $usuario->delete();

        return back()->with('success', 'El usuario ha sido dado de baja correctamente.');
    }

    public function createCategoria()
    {
        return view('admin.categorias.create');
    }

    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría con este nombre.'
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.productos.index')->with('success', '¡Nueva categoría creada con éxito!');
    }
}
