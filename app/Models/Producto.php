<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes; // Activa el borrado logico

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'url_imagen',
        'activo',
        'categoria_id',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
    ];

    // RELACION: Un producto pertenece a una sola categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // RELACION: Un producto puede estan en muchos detalles de pedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
