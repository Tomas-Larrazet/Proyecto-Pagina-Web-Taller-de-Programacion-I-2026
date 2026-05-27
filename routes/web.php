<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;

Route::get('/', [InicioController::class, 'index'])->name('principal');


Route::get('/comercializacion', function () {
    return view('comercializacion');
});

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
});

Route::get('/contactos', function () {
    return view('contactos');
});

Route::get('/terminos-y-uso', function () {
    return view('terminos-y-uso');
});

Route::get('/catalogo', function () {
    return view('catalogo');
});

Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo.index');

Route::get('/consultas', function () {
    return view('consultas');
});

Route::post('/contactos', [ConsultaController::class, 'procesar']);

Route::get('/exito', function () {
    return view('exito');
});

/*
Route::get('/RegistroUsuario', function (){
    return view('RegistroUsuario');
});

Route::post('/RegistroUsuario', function () {
    return view('exito1');
});

Route::get('/logIn', function (){
    return view('logIn');
});

Route::post('/ProcesarLogin', function () {
    return redirect('/');
});
*/

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