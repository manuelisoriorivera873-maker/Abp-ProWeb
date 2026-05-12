<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    
    // IMPORTANTE: Como en tu SQL no usas AUTO_INCREMENT,
    // avisamos a Laravel que no intente incrementar el ID automáticamente.
    public $incrementing = true; 
    
    public $timestamps = false;
    
    protected $fillable = [
        'codigo',  
        'nombre',   
        'descripcion',  
        'precio_compra',    
        'precio_venta', 
        'stock',    
        'categoria',    
        'id_proveedor'
    ];

    public function proveedor()
    {
        return $this->belongsTo(proveedor::class, 'id_proveedor');
    }
}