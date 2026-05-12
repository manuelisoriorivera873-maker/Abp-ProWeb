@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Editar Pago #{{ $pago_proveedor->id_pago }}</h1>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px;">
        <form action="{{ route('pagos_proveedores.update', ['pagos_proveedore' => $pago_proveedor->id_pago]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ $pago_proveedor->fecha }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Proveedor</label>
                <select name="id_proveedor" class="form-select" required>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id_proveedor }}" {{ $p->id_proveedor == $pago_proveedor->id_proveedor ? 'selected' : '' }}>
                            {{ $p->nombre_comercial }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Método de Pago</label>
                <select name="metodo_pago" class="form-select" required>
                    <option value="Efectivo" {{ $pago_proveedor->metodo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="Transferencia" {{ $pago_proveedor->metodo_pago == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Monto</label>
                <input type="number" step="0.01" name="monto" class="form-control" value="{{ $pago_proveedor->monto }}" required>
            </div>

            <div class="d-flex gap-2 justify-content-center">
                <button type="submit" class="btn btn-warning fw-bold px-5 text-white">Actualizar Registro</button>
                <a href="{{ route('pagos_proveedores.index') }}" class="btn btn-secondary px-5">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection