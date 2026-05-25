<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    public $timestamps = false; // Ajusta a true si tu base de datos tiene created_at/updated_at

    protected $fillable = [
        'fecha',    
        'hora',    // <--- Agregamos este campo
        'total',
        'tipo_venta'
    ];

    /**
     * Relación: Una venta tiene muchos detalles (productos vendidos)
     */
    public function detalles()
    {
        return $this->hasMany(detalle_venta::class, 'id_venta', 'id_venta');
    }
}