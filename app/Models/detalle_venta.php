<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalle_venta extends Model
{
    protected $table = 'detalles_ventas'; // Nombre exacto en tu BD
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio_unitario'
    ];

    // Relación para saber qué producto es cada detalle
    public function producto()
    {
        return $this->belongsTo(producto::class, 'id_producto', 'id_producto');
    }
}