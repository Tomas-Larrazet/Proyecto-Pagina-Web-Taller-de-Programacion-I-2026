<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('principal');
});

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

Route::get('/catalogo-abridores', function () {
    return view('catalogo-abridores');
});

Route::get('/catalogo-escarapelas', function (){
    return view('catalogo-escarapelas');
});

Route::get('/catalogo-argollas', function (){
    return view('catalogo-argollas');
});

Route::get('/catalogo-aros', function (){
    return view('catalogo-aros');
});

Route::get('/catalogo-anillos', function (){
    return view('catalogo-anillos');
});

Route::get('/catalogo-pulseras', function (){
    return view('catalogo-pulseras');
});

Route::get('/catalogo-conjuntos', function (){
    return view('catalogo-conjuntos');
});

Route::get('/catalogo-broches', function (){
    return view('catalogo-broches');
});

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
    return redirect('/'); // Esto te manda directo a la página principal
});