<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\proveedor; 
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos del inventario.
     */
    public function index()
    {
        // Cargamos la relación 'proveedor' para evitar el problema N+1 en la vista
        $productos = producto::with('proveedor')->get();
        return view('producto.index', compact('productos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo producto.
     */
    public function create()
    {
        $proveedores = proveedor::all();
        return view('producto.create', compact('proveedores'));
    }
    public function show(Producto $producto){

        $proveedores = proveedor::all();
        return view('producto.create', compact('proveedores','producto'));
    }

    /**
     * Guarda el producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Se usa asignación masiva. Asegúrate de tener 'codigo' en el $fillable del modelo.
        producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente en Tienda La Subidita.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit($id)
    {
        $producto = producto::findOrFail($id);
        $proveedores = proveedor::all();
        return view('producto.edit', compact('producto', 'proveedores'));
    }

    /**
     * Actualiza los datos del producto en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $producto = producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina el producto del sistema.
     */
    public function destroy($id)
    {
        $producto = producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado del inventario.');
    }
}