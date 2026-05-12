<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    protected $fillable = [
        'fecha',    
        'total',
        'tipo_venta'
    ];

    /**
     * Relación: Una venta tiene muchos detalles (productos vendidos)
     */
    public function detalles()
    {
        // Esto permite que en el ticket (show) puedas acceder a los productos
        return $this->hasMany(detalle_venta::class, 'id_venta', 'id_venta');
    }
}
