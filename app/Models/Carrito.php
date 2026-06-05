<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad'
    ];

    // Un registro del carrito pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Un registro del carrito pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
