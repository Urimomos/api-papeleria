<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // 1. Definimos qué columnas se pueden llenar masivamente
    // Esto es por seguridad, para evitar que hackeen otros campos
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'activo'
    ];
}