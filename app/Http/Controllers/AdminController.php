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
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $totalUsuarios = User::count();

        $totalProductos = Producto::count();

        // Solo contamos ventas que NO estén canceladas
        $totalVentas = Pedido::where('estado', '!=', 'cancelado')->count();

        // Solo sumamos ingresos de ventas NO canceladas
        $ingresos = Pedido::where('estado', '!=', 'cancelado')->sum('total');

        $productosStockBajo = Producto::where('stock','<=',5)
        ->get();

        $topProductos = DetallePedido::select(
        'producto_id',
        \DB::raw('SUM(cantidad) as total_vendido')
        )
        ->whereHas('pedido', function($q) {
            $q->where('estado', '!=', 'cancelado');
        })
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

    public function productos(Request $request)
    {
        $query = Producto::with('categoria');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'LIKE', '%' . $request->buscar . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->filled('stock')) {
            if ($request->stock == 'bajo') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            } elseif ($request->stock == 'sin_stock') {
                $query->where('stock', 0);
            }
        }

        $productos = $query->orderBy('id', 'asc')->get();
        $categorias = Categoria::all();

        return view('admin.productos.index', compact('productos', 'categorias'));
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

    public function ventas(Request $request)
{
    $query = Pedido::query();

    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    if ($request->filled('fecha_desde')) {
        $query->whereDate('created_at', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('created_at', '<=', $request->fecha_hasta);
    }

    if ($request->filled('monto_min')) {
        $query->where('total', '>=', $request->monto_min);
    }

    if ($request->filled('monto_max')) {
        $query->where('total', '<=', $request->monto_max);
    }

    $ventas = $query->orderBy('created_at', 'desc')->get();

    return view('admin.ventas.index', compact('ventas'));
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

        $estadoAnterior = $pedido->estado;
        $estadoNuevo = $request->estado;

        DB::beginTransaction();

        try {
            // Si el pedido se cancela y antes NO estaba cancelado, devolvemos el stock
            if ($estadoNuevo === 'cancelado' && $estadoAnterior !== 'cancelado') {
                $detalles = DetallePedido::where('pedido_id', $pedido->id)->get();

                foreach ($detalles as $detalle) {
                    $producto = Producto::find($detalle->producto_id);
                    if ($producto) {
                        $producto->stock += $detalle->cantidad;
                        $producto->save();
                    }
                }
            }

            // Si se reactiva un pedido que estaba cancelado, volvemos a descontar el stock
            if ($estadoAnterior === 'cancelado' && $estadoNuevo !== 'cancelado') {
                $detalles = DetallePedido::where('pedido_id', $pedido->id)->get();

                foreach ($detalles as $detalle) {
                    $producto = Producto::find($detalle->producto_id);
                    if ($producto) {
                        $producto->stock -= $detalle->cantidad;
                        $producto->save();
                    }
                }
            }

            $pedido->estado = $estadoNuevo;
            $pedido->save();

            DB::commit();

            return redirect()->back()->with('success','Estado actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el estado del pedido.');
        }
    }

    public function consultas(Request $request)
    {
        $query = Consulta::query();

        if ($request->filled('tipo')) {
            if ($request->tipo == 'registrado') {
                $query->whereNotNull('user_id');
            } elseif ($request->tipo == 'visitante') {
                $query->whereNull('user_id');
            }
        }

        $consultas = $query->orderBy('created_at', 'desc')->get();
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

    public function cambiarRol(Request $request, $id)
    {
        $request->validate([
            'rol' => 'required|in:cliente,admin',
        ]);

        $usuario = User::findOrFail($id);

        // No permitimos que un admin se quite el rol a sí mismo (seguridad extra)
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No podés cambiar tu propio rol.');
        }

        $usuario->rol = $request->rol;
        $usuario->save();

        return back()->with('success', 'El rol de ' . $usuario->name . ' fue actualizado a ' . ($request->rol === 'admin' ? 'Administrador' : 'Cliente') . '.');
    }
}
