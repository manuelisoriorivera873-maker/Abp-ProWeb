<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

class InventarioProductoController extends Controller
{
    public function index()
    {
        $productos = producto::all();
        return view('inventario_producto.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear
     */
    public function create()
    {
        return view('inventario_producto.create');
    }

    /**
     * Guarda un nuevo producto (Asignación manual sin comentarios de validación)
     */
    public function store(Request $request)
    {
        $producto = new producto();
        $producto->nombre = $request->nombre;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = $request->stock;
        $producto->categoria = $request->categoria;
        $producto->codigo = $request->codigo;
        $producto->save();

        return redirect()->route('inventarios_productos.index')
                         ->with('success', 'Producto registrado con éxito');
    }

    /**
     * NUEVO MÉTODO: Incrementa el stock existente desde la ventana emergente de SweetAlert2
     */
    public function incrementarStock(Request $request, $id)
    {
        $producto = producto::findOrFail($id);
        
        // Sumamos la cantidad nueva ingresada en la alerta al stock que ya tiene el producto
        $producto->stock = $producto->stock + $request->cantidad_nueva;
        $producto->save();

        return redirect()->route('inventarios_productos.index')
                         ->with('success', 'Se han añadido ' . $request->cantidad_nueva . ' unidades a las existencias de: ' . $producto->nombre . ' 🎉');
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit($id)
    {
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