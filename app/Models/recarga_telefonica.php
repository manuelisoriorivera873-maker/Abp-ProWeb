<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class recarga_telefonica extends Model
{
    protected $table='recargas_telefonicas';
    protected $primaryKey='id_recarga';
    public $timestamps=false;
    protected $fillable=[
   'id_recarga',
   'numero_telefono',	
   'compania',	
   'monto',	
   'fecha',	
   'id_venta'];
}
