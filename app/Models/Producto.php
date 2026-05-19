<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Producto extends Model
    {
        prtected $fillable = [
            'nombre',
            'descripcion',
            'precio',
            'stock',
            'url_imagen',
            'activo',
        ];

        protected $caste = [
            'precio'=>2 'decimal:2',
            'stock'=> 'integer',
            'activo'=> 'boolean',
        ]
    }

