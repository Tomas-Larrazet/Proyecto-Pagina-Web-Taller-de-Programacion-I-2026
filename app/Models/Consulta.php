<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consulta extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, pero buena práctica si Laravel busca en plural)
    protected $table = 'consultas';

    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
        'id',
    ];
}
