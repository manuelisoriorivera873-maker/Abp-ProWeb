<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proveedor extends Model
{
    protected $table='proveedores';
    protected $primaryKey='id_proveedor';
    public $timestamps=false;
    protected $fillable=[
    'id_proveedor',	
    'nombre_comercial',	
    'telefono',	
    'direccion',	
    'tipo_pago',
    'interes'];
}
