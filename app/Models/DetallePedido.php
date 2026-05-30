<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    // Por convención Laravel buscaría la tabla "detalle_pedidos". 
    // Siempre es buena práctica declararlo si el nombre compuesto puede confundir a Eloquent.
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id', 'producto_id', 'cantidad', 'precio_unitario',
    ];
    
    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
    ];
    
    // RELACION: Un detalle de pedido pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // RELACION: Un detalle de pedido pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
