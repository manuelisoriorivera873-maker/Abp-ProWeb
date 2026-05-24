<?php

namespace App\Http\Controllers;

use App\Models\recarga_telefonica;
use App\Models\saldo_disponible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecargaTelefonicaController extends Controller
{
    public function index()
    {
        $recargas = recarga_telefonica::orderBy('id_recarga', 'desc')->get();
        return view('recarga_telefonica.index', compact('recargas'));
    }

    public function create()
    {
        return view('recarga_telefonica.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_telefono' => 'required',
            'monto' => 'required|numeric|min:1',
            'compania' => 'required'
        ]);

        $saldoCaja = saldo_disponible::find(1);

        if (!$saldoCaja || $saldoCaja->saldo_disponible < $request->monto) {
            return back()->with('error', 'Saldo insuficiente en caja para realizar esta recarga.');
        }

        DB::transaction(function () use ($request, $saldoCaja) {
            $recarga = new recarga_telefonica();
            $recarga->numero_telefono = $request->numero_telefono;
            $recarga->compania = $request->compania;
            $recarga->monto = $request->monto;
            $recarga->fecha = $request->fecha ?? now();
            $recarga->id_venta = $request->id_venta;
            $recarga->save();

            $saldoCaja->decrement('saldo_disponible', $request->monto);
        });

        return redirect()->route('recargas_telefonicas.index')
                         ->with('success', 'Recarga registrada y saldo descontado con éxito');
    }

    public function show(int $id)
    {
        $recarga = recarga_telefonica::where('id_recarga', $id)->firstOrFail();
        return view('recarga_telefonica.show', compact('recarga'));
    }

    public function edit(int $id)
    {
        $recarga = recarga_telefonica::where('id_recarga', $id)->firstOrFail();
        return view('recarga_telefonica.edit', compact('recarga'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'numero_telefono' => 'required',
            'monto' => 'required|numeric|min:1',
            'compania' => 'required',
            'fecha' => 'required'
        ]);

        $recarga = recarga_telefonica::where('id_recarga', $id)->firstOrFail();

        $recarga->update([
            'numero_telefono' => $request->numero_telefono,
            'compania' => $request->compania,
            'monto' => $request->monto,
            'fecha' => $request->fecha
        ]);

        return redirect()->route('recargas_telefonicas.index')->with('success', 'Recarga actualizada.');
    }

    public function destroy(int $id)
    {
        $recarga = recarga_telefonica::where('id_recarga', $id)->firstOrFail();
        $recarga->delete();

        return redirect()->route('recargas_telefonicas.index')->with('success', 'Recarga eliminada.');
    }
}
