<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Una categoria tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
