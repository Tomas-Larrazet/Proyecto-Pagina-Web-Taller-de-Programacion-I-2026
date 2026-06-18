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

Route::middleware('guest')->group(function () {
    Route::get('/registroUsuario', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registroUsuario', [AuthController::class, 'register']);

    Route::get('/logIn', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/logIn', [AuthController::class, 'login']);
});


Route::post('/logOut', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/mis-compras', [PedidoController::class, 'index'])->middleware('auth')->name('mis-compras');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
});

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
    Route::post('/carrito/actualizar-cantidad/{id}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizarCantidad');

});


Route::middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->group(function () {
    
    Route::get('/admin/panel-principal', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.panel-principal');

    Route::get('/admin/productos', [App\Http\Controllers\AdminController::class, 'productos'])->name('admin.productos.index');

    Route::delete('/admin/productos/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.productos.destroy');

    Route::get('/admin/productos/crear', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.productos.create');
    Route::post('/admin/productos', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.productos.store');

    Route::get('/admin/categorias/crear', [App\Http\Controllers\AdminController::class, 'createCategoria'])->name('admin.categorias.create');
    Route::post('/admin/categorias', [App\Http\Controllers\AdminController::class, 'storeCategoria'])->name('admin.categorias.store');

    Route::get('/admin/productos/{id}/editar', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.productos.edit');
    Route::put('/admin/productos/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.productos.update');

    Route::get('/admin/ventas', [App\Http\Controllers\AdminController::class, 'ventas'])->name('admin.ventas.index');

    Route::get('/admin/ventas/{id}', [App\Http\Controllers\AdminController::class, 'showVenta'])->name('admin.ventas.show');

    Route::put('/admin/pedido/{pedido}/estado', [AdminController::class,'cambiarEstado'])->name('admin.pedidos.estado');

    Route::get('/admin/consultas', [App\Http\Controllers\AdminController::class, 'consultas'])->name('admin.consultas.index');

    Route::get('/admin/usuarios', [App\Http\Controllers\AdminController::class, 'usuarios'])->name('admin.usuarios.index');

    Route::get('/admin/usuarios/crear-admin', [App\Http\Controllers\AdminController::class, 'createAdmin'])->name('admin.usuarios.create_admin');
    Route::post('/admin/usuarios/crear-admin', [App\Http\Controllers\AdminController::class, 'storeAdmin'])->name('admin.usuarios.store_admin');

    Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.usuarios.destroy');

    Route::put('/admin/usuarios/{id}/rol', [App\Http\Controllers\AdminController::class, 'cambiarRol'])->name('admin.usuarios.cambiarRol');


});
