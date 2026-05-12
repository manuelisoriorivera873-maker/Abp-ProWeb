<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;
    
    protected $fillable = [
        'id_producto',
        'codigo',  
        'nombre',   
        'descripcion',  
        'precio_compra',    
        'precio_venta', 
        'stock',    
        'categoria',    
        'id_proveedor'
    ];

    // ESTO ES LO QUE FALTA:
    public function proveedor()
    {
        // Se conecta con el modelo 'proveedor' usando la columna 'id_proveedor'
        return $this->belongsTo(proveedor::class, 'id_proveedor');
    }
}