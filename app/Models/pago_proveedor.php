<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pago_proveedor extends Model
{
    protected $table = 'pagos_proveedores';
    protected $primaryKey = 'id_pago';
    public $timestamps = false;
    
    protected $fillable = [
        'id_pago',  
        'fecha',    
        'monto',    
        'metodo_pago',  
        'id_proveedor'
    ];

    // ESTO ES LO QUE FALTA PARA QUITAR EL ERROR:
    public function proveedor()
    {
        // Conectamos este pago con el modelo 'proveedor' usando la columna 'id_proveedor'
        return $this->belongsTo(proveedor::class, 'id_proveedor');
    }
}