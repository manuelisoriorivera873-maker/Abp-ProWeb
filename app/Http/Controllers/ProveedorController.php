<?php

namespace App\Http\Controllers;

use App\Models\proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = proveedor::all();
        return view('proveedor.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedor.create');
    }

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

    public function edit($id)
    {
        $proveedor = proveedor::where('id_proveedor', $id)->firstOrFail();
        return view('proveedor.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $proveedor = proveedor::where('id_proveedor', $id)->firstOrFail();
        $proveedor->nombre_comercial = $request->nombre_comercial;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->tipo_pago = $request->tipo_pago;
        $proveedor->interes = $request->interes;
        $proveedor->save();

        return redirect()->route('proveedores.index');
    }

    public function destroy($id)
    {
        $proveedor = proveedor::where('id_proveedor', $id)->firstOrFail();
        $proveedor->delete();

        return redirect()->route('proveedores.index');
    }
}
