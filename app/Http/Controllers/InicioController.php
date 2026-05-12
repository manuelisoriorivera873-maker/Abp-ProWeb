<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // Importamos el modelo de productos para consultar la base de datos

class InicioController extends Controller
{
    /**
     * Muestra el Dashboard de la Tienda
     */
    public function index()
{
    // Usamos 'stock' y 'nombre' que son los nombres reales en tu SQL
    $stockBajo = Producto::where('stock', '<', 10)
        ->orderBy('stock', 'asc')
        ->take(5)
        ->get();

    // Usamos 'precio_venta' para encontrar el producto más caro
    $productoTop = Producto::orderBy('precio_venta', 'desc')->first();

    return view('inicio.index', compact('stockBajo', 'productoTop'));
}
}