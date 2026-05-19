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

    public function show($id)
{
    // Redirigir al index si alguien intenta entrar a /productos/{id}
    return redirect()->route('productos.index');
}
    public function store(Request $request)
    {
        $request->validate([
            'codigo'        => 'required|string|unique:productos,codigo|max:50',
            'nombre'        => 'required|string|max:100',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta'  => 'required|numeric|gt:precio_compra',
            'stock'         => 'required|integer|min:0',
            'id_proveedor'  => 'required|exists:proveedores,id_proveedor',
        ], [
            'codigo.required'      => 'El código de barras es obligatorio.',
            'codigo.unique'        => 'Este código ya pertenece a otro producto.',
            'nombre.required'      => 'El nombre del producto es necesario.',
            'precio_venta.gt'      => '¡Cuidado! El precio de venta debe ser mayor al de compra para generar ganancia.',
            'id_proveedor.exists'   => 'El proveedor seleccionado no es válido.'
        ]);

        producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado exitosamente en Tienda La Subidita.');
    }

    /**
     * Método nuevo: Sumar stock al inventario existente
     */
    public function sumarStock(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ], [
            'cantidad.required' => 'Debes ingresar una cantidad.',
            'cantidad.min'      => 'La cantidad a sumar debe ser al menos 1.'
        ]);

        $producto = producto::findOrFail($id);
        
        // Lógica de coherencia: sumamos a lo que ya hay
        $producto->stock += $request->cantidad;
        $producto->save();

        return redirect()->route('productos.index')
            ->with('success', "Se han añadido {$request->cantidad} unidades a {$producto->nombre} correctamente.");
    }

    public function edit($id)
    {
        $producto = producto::findOrFail($id);
        $proveedores = proveedor::all();
        return view('producto.edit', compact('producto', 'proveedores'));
    }

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
            'codigo.unique'   => 'Este código ya lo tiene otro producto.',
            'precio_venta.gt' => 'El precio de venta debe ser mayor al de compra.'
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado del inventario.');
    }
}
