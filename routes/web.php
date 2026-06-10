<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PerfilController;

Route::get('/', [InicioController::class, 'index'])->name('principal');


Route::get('/comercializacion', function () {
    return view('comercializacion');
});

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
});

Route::get('/terminos-y-uso', function () {
    return view('terminos-y-uso');
});

Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo.index');

Route::get('/consultas', function () {
    return view('consultas');
});

Route::get('/contactos', function () {
    return view('contactos');
});

Route::post('/contactos', [ConsultaController::class, 'guardarConsulta']);

// Rutas para USUARIOS VISITANTES (solo acceden si NO estan logueados)
Route::middleware('guest')->group(function () {
    // Registro de usuario
    Route::get('/registroUsuario', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registroUsuario', [AuthController::class, 'register']);

    // Login
    Route::get('/logIn', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/logIn', [AuthController::class, 'login']);
});

// Rutas para USUARIOS LOGUEADOS

Route::post('/logOut', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/mis-compras', [PedidoController::class, 'index'])->middleware('auth')->name('mis-compras');

Route::middleware('auth')->group(function () {
    // Rutas para editar perfil
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
});

// Rutas para el carrito de compras (solo accesibles para usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::post('/carrito/comprar', [CarritoController::class, 'comprar'])->name('carrito.comprar');
    Route::post('/carrito/actualizar/{id}', [App\Http\Controllers\CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::post('/carrito/cupon', [CarritoController::class, 'aplicarCupon'])->name('carrito.cupon');

    Route::get('/compra-exitosa/{id}', [CarritoController::class, 'compraExitosa'])->name('compra.exitosa');
    Route::get('/mis-compras/factura/{id}', [App\Http\Controllers\PedidoController::class, 'descargarFactura'])->name('pedidos.factura');
});


// Rutas exclusivas para el ADMINISTRADOR
Route::middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->group(function () {
    
    // Panel principal
    Route::get('/admin/panel-principal', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.panel-principal');

    // Rutas para el CRUD de Productos

    // Listado de productos
    Route::get('/admin/productos', [App\Http\Controllers\AdminController::class, 'productos'])->name('admin.productos.index');

    // Borrar producto (Baja lógica)
    Route::delete('/admin/productos/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.productos.destroy');

    //Crear productos
    Route::get('/admin/productos/crear', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.productos.create');
    Route::post('/admin/productos', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.productos.store');

    // Gestión de Categorías
    Route::get('/admin/categorias/crear', [App\Http\Controllers\AdminController::class, 'createCategoria'])->name('admin.categorias.create');
    Route::post('/admin/categorias', [App\Http\Controllers\AdminController::class, 'storeCategoria'])->name('admin.categorias.store');

    // Editar producto
    Route::get('/admin/productos/{id}/editar', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.productos.edit');
    Route::put('/admin/productos/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.productos.update');

    // Historial de Ventas
    Route::get('/admin/ventas', [App\Http\Controllers\AdminController::class, 'ventas'])->name('admin.ventas.index');

    // Ver detalle de una venta
    Route::get('/admin/ventas/{id}', [App\Http\Controllers\AdminController::class, 'showVenta'])->name('admin.ventas.show');

    // Bandeja de Consultas/Contacto
    Route::get('/admin/consultas', [App\Http\Controllers\AdminController::class, 'consultas'])->name('admin.consultas.index');

    // Listado de Usuarios Registrados
    Route::get('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'usuarios'])->name('admin.usuarios.index');

    // Crear nuevos Administradores
    Route::get('/admin/usuarios/crear-admin', [App\Http\Controllers\AdminController::class, 'createAdmin'])->name('admin.usuarios.create_admin');
    Route::post('/admin/usuarios/crear-admin', [App\Http\Controllers\AdminController::class, 'storeAdmin'])->name('admin.usuarios.store_admin');

    // Eliminar/Dar de baja a un usuario o admin
    Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.usuarios.destroy');


});
