<?php

namespace App\Http\Controllers;

use App\Models\proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Muestra la lista de proveedores.
     */
    public function index()
    {
        $proveedores = proveedor::all();
        return view('proveedor.index', compact('proveedores'));
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('proveedor.create');
    }

    /**
     * Guarda un nuevo proveedor en la base de datos.
     */
    public function store(Request $request)
    {
        $proveedor = new proveedor();
        $proveedor->nombre_comercial = $request->nombre_comercial;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->tipo_pago = $request->tipo_pago;
        $proveedor->interes = $request->interes;
        $proveedor->save();

        return redirect()->route('proveedores.index');
    }

    /**
     * Muestra el formulario para editar un proveedor específico.
     */
    public function edit($id)
    {
        // Buscamos por id_proveedor que es el nombre en tu lógica de vistas
        $proveedor = proveedor::findOrFail($id);
        return view('proveedor.edit', compact('proveedor'));
    }

    /**
     * Actualiza el proveedor en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $proveedor = proveedor::findOrFail($id);
        $proveedor->nombre_comercial = $request->nombre_comercial;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->tipo_pago = $request->tipo_pago;
        $proveedor->interes = $request->interes;
        $proveedor->save();

        return redirect()->route('proveedores.index');
    }

    /**
     * Elimina un proveedor de la base de datos.
     */
    public function destroy($id)
    {
        $proveedor = proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index');
    }
}