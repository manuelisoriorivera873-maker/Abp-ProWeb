<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\proveedor; 
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = producto::with('proveedor')->get();
        return view('producto.index', compact('productos'));
    }

    public function create()
    {
        $proveedores = proveedor::all();
        return view('producto.create', compact('proveedores'));
    }

    public function show(producto $producto)
    {
        $proveedores = proveedor::all();
        return view('producto.show', compact('proveedores','producto'));
    }

    /**
     * Guarda el producto con validaciones de coherencia y mensajes en español.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo'        => 'required|string|unique:productos,codigo|max:50',
            'nombre'        => 'required|string|max:100',
            'precio_compra' => 'required|numeric|min:0',
            // COHERENCIA: El precio de venta debe ser mayor al de compra para asegurar ganancia
            'precio_venta'  => 'required|numeric|gt:precio_compra',
            'stock'         => 'required|integer|min:0',
            'id_proveedor'  => 'required|exists:proveedores,id_proveedor',
        ], [
            'codigo.required'      => 'El código de barras es obligatorio para el inventario.',
            'codigo.unique'        => 'Este código ya pertenece a otro producto registrado.',
            'nombre.required'      => 'El nombre del producto es necesario.',
            'precio_compra.required' => 'Ingresa el costo de compra.',
            'precio_venta.required'  => 'El precio de venta no puede quedar vacío.',
            'precio_venta.gt'      => '¡Cuidado! El precio de venta debe ser mayor al de compra para generar ganancia.',
            'stock.required'       => 'Debes indicar cuántas piezas hay en existencia.',
            'id_proveedor.required' => 'Selecciona un proveedor de la lista.',
            'id_proveedor.exists'   => 'El proveedor seleccionado no es válido o no existe.'
        ]);

        // Al ser autoincrementable, Laravel y MySQL se encargan del ID solo.
        producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado exitosamente en Tienda La Subidita.');
    }

    public function edit($id)
    {
        $producto = producto::findOrFail($id);
        $proveedores = proveedor::all();
        return view('producto.edit', compact('producto', 'proveedores'));
    }

    /**
     * Actualiza validando que el código no choque, excepto con el mismo producto.
     */
    public function update(Request $request, $id)
    {
        $producto = producto::findOrFail($id);

        $request->validate([
            'codigo'        => 'required|string|max:50|unique:productos,codigo,' . $id . ',id_producto',
            'nombre'        => 'required|string|max:100',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta'  => 'required|numeric|gt:precio_compra',
            'stock'         => 'required|integer|min:0',
            'id_proveedor'  => 'required|exists:proveedores,id_proveedor',
        ], [
            'codigo.unique'   => 'Este código de barras ya lo tiene otro producto.',
            'precio_venta.gt' => 'El precio de venta debe ser mayor al precio de compra.',
            'id_proveedor.exists' => 'El proveedor seleccionado no es válido.'
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = producto::findOrFail($id);
        
        // Opcional: Podríamos verificar si tiene ventas antes de borrar,
        // pero por ahora hacemos el borrado directo.
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado del inventario.');
    }
}