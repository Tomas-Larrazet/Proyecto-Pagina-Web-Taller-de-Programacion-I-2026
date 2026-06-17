<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id', 'producto_id', 'cantidad', 'precio_unitario',
    ];
    
    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
    ];
    
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
