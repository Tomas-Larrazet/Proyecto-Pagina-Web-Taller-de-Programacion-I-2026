<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
        'user_id',
    ];
}
