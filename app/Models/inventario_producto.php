<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    // Nombre exacto en BD.sql
    protected $table = 'productos';
    // Llave primaria exacta en BD.sql
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'descripcion', 'precio_compra', 
        'precio_venta', 'stock', 'categoria', 'id_proveedor'
    ];
}