<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id', 'total', 'estado',
    ];
    
    // RELACION: Un pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELACION: Un pedido tiene muchos detalles de pedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
