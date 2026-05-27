<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class InicioController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('principal', compact('categorias'));
    }
}
