<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class saldo_disponible extends Model
{
    // 1. Nombre de la tabla tal cual está en tu base de datos
    protected $table = 'saldo_recargas';

    // 2. Nombre de la llave primaria personalizada
    protected $primaryKey = 'id_saldo';

    // 3. Como tu tabla no tiene las columnas 'created_at' y 'updated_at', desactivamos los timestamps
    public $timestamps = false;

    // 4. Permitimos la asignación masiva del campo de saldo
    protected $fillable = ['saldo_disponible'];
}