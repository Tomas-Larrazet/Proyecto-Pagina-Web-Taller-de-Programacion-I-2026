<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\CarritoController;

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

// Rutas para el carrito de compras (solo accesibles para usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    Route::post('/carrito/comprar', [CarritoController::class, 'comprar'])->name('carrito.comprar');
});