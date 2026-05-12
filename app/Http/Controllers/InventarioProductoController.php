<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

class InventarioProductoController extends Controller
{
    public function index()
    {
        $productos = producto::all();
        // Asegúrate de que la carpeta sea 'inventario_producto' o donde tengas tu index
        return view('inventario_producto.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear (Pedir más)
     */
    public function create()
    {
        return view('producto.create');
    }

    /**
     * Guarda un nuevo producto
     */
    public function store(Request $request)
    {
        // Guardado directo sin $request->validate() por petición previa
        $producto = new producto();
        $producto->nombre = $request->nombre;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = $request->stock;
        $producto->categoria = $request->categoria;
        $producto->codigo = $request->codigo; // Si usas escáner
        $producto->save();

        return redirect()->route('inventarios_productos.index')
                         ->with('success', 'Producto registrado con éxito');
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit($id)
    {
        // Buscamos por el ID que viene de la tabla
        $producto = producto::findOrFail($id);
        return view('inventario_producto.edit', compact('producto'));
    }

    /**
     * Actualiza los datos del producto
     */
    public function update(Request $request, $id)
    {
        $producto = producto::findOrFail($id);
        
        $producto->nombre = $request->nombre;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = $request->stock;
        $producto->categoria = $request->categoria;
        $producto->codigo = $request->codigo;
        $producto->save();

        return redirect()->route('inventarios_productos.index')
                         ->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Elimina el producto
     */
    public function destroy($id)
    {
        $producto = producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('inventarios_productos.index')
                         ->with('success', 'Producto eliminado correctamente');
    }
}