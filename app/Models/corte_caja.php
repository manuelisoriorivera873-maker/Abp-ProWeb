<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class corte_caja extends Model
{
    protected $table = 'cortes_caja';
    protected $primaryKey = 'id_corte';
    
    // Desactivamos timestamps si no usas updated_at, 
    // tu SQL ya tiene created_at por defecto
    public $timestamps = false; 

    protected $fillable = [
        'fecha_corte',
        'hora_cierre',
        'total_ventas',
        'total_recargas',
        'total_pagos',
        'total_esperado',
        'total_real',
        'diferencia',
        'observaciones'
    ];
}